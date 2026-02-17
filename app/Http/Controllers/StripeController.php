<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createOnboardingLink()
    {
        $user = auth()->user();
        $band = $user->band;

        if (!$band || !$band->stripe_account_id) {
            return response()->json([
                'success' => false,
                'message' => 'No existe cuenta Stripe para esta banda.'
            ], 400);
        }

        $accountLink = AccountLink::create([
            'account' => $band->stripe_account_id,
            'refresh_url' => config('app.frontend_url') . '/stripe/refresh',
            'return_url' => config('app.frontend_url') . '/stripe/complete',
            'type' => 'account_onboarding',
        ]);

        return response()->json([
            'url' => $accountLink->url
        ]);
    }

    public function createPaymentSession(Contract $contract)
    {
        $user = auth()->user();

        // Verificar que la hermandad es la propietaria del contrato
        if ($user->brotherhood_id !== $contract->brotherhood_id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado para pagar este contrato.'
            ], 403);
        }

        if ($contract->status === Contract::STATUS_PAID) {
            return response()->json([
                'success' => false,
                'message' => 'Este contrato ya está pagado.'
            ], 400);
        }

        // Solo permitir pago si contrato está COMPLETADO
        if ($contract->status !== Contract::STATUS_COMPLETED) {
            return response()->json([
                'success' => false,
                'message' => 'El contrato debe estar firmado por ambos antes de pagar.'
            ], 400);
        }

        // Verificar que la banda tiene cuenta Stripe
        if (!$contract->band->stripe_account_id) {
            return response()->json([
                'success' => false,
                'message' => 'La banda no tiene cuenta Stripe configurada.'
            ], 400);
        }

        // Verificar que la cuenta Stripe está habilitada para cobrar
        $account = Account::retrieve($contract->band->stripe_account_id);

        if (!$account->charges_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'La banda no ha completado sus datos bancarios en Stripe.'
            ], 400);
        }

        $amountInCents = (int) bcmul($contract->amount, 100);
        $applicationFee = (int) round($amountInCents * 0.05);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Contrato #' . $contract->id,
                    ],
                    'unit_amount' => $amountInCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => config('app.frontend_url') . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => config('app.frontend_url') . '/payment-cancel',

            'metadata' => [
                'contract_id' => $contract->id
            ],
            'payment_intent_data' => [
                'application_fee_amount' => $applicationFee,
                'on_behalf_of' => $contract->band->stripe_account_id,
                'metadata' => [
                    'contract_id' => $contract->id
                ],
                'transfer_data' => [
                    'destination' => $contract->band->stripe_account_id
                ],
            ],
        ]);

        $contract->update([
            'stripe_session_id' => $session->id
        ]);

        return response()->json([
            'success' => true,
            'url' => $session->url
        ]);
    }


    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        switch ($event->type) {

            case 'payment_intent.succeeded':

                $paymentIntent = $event->data->object;

                $contractId = $paymentIntent->metadata->contract_id ?? null;

                if ($contractId) {
                    $contract = Contract::find($contractId);

                    if ($contract && $contract->status !== Contract::STATUS_PAID) {
                        $contract->update([
                            'status' => Contract::STATUS_PAID,
                            'paid_at' => now(),
                            'stripe_payment_intent_id' => $paymentIntent->id
                        ]);
                    }

                    if (!$contract->invoice) {

                        $nextId = (Invoice::max('id') ?? 0) + 1;

                        Invoice::create([
                            'contract_id' => $contract->id,
                            'number' => 'FAC-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
                            'amount' => $contract->amount,
                            'commission_amount' => round($contract->amount * 0.05, 2),
                            'issued_at' => now()
                        ]);
                    }
                }

                break;

            default:
                \Log::info('Evento no manejado: ' . $event->type);
        }

        return response()->json(['received' => true]);
    }

    public function checkStripeAccountStatus(Request $request)
    {
        $user = auth()->user();
        $stripeAccountId = $user->band->stripe_account_id;

        if (!$stripeAccountId) {
            return response()->json([
                'connected' => false,
                'message' => 'El usuario no tiene una cuenta de Stripe conectada'
            ]);
        }

        try {
            $account = Account::retrieve($stripeAccountId);

            $isReady = $account->charges_enabled === true;

            $band = $user->band;
            $band->update([
                'stripe_onboarding_completed' => $isReady
            ]);

            return response()->json([
                'success' => true,
                'onboarding_completed' => $isReady,
                'charges_enabled' => $account->charges_enabled,
                'payouts_enabled' => $account->payouts_enabled,
                'currently_due' => $account->requirements->currently_due,
                'disabled_reason' => $account->requirements->disabled_reason,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
