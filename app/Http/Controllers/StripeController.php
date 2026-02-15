<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function createPaymentSession(Contract $contract)
    {
        $user = auth()->user();

        if ($user->brotherhood_id !== $contract->brotherhood_id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado para pagar este contrato.'
            ], 403);
        }

        // ✅ Solo permitir pago si contrato está COMPLETADO
        if ($contract->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'El contrato debe estar firmado por ambos antes de pagar.'
            ], 400);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $amountInCents = $contract->amount * 100;

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
            'success_url' => env('FRONTEND_URL') . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => env('FRONTEND_URL') . '/payment-cancel',
            'client_reference_id' => $contract->id,
            'payment_intent_data' => [
                'transfer_data' => [
                    'destination' => $contract->band->stripe_account_id // <-- aquí la cuenta de la banda
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
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $webhookSecret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        // ✅ Manejar el evento
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                // Por ejemplo, buscar el contrato relacionado
                $contractId = $session->client_reference_id; // Esto lo envías al crear la sesión de pago
                $contract = Contract::find($contractId);

                if ($contract) {
                    $contract->update([
                        'status' => 'paid', // marcar como pagado
                    ]);
                }
                break;

            // puedes manejar otros eventos si quieres
            default:
                // Loguear para futuras referencias
                \Log::info('Evento no manejado: ' . $event->type);
        }

        return response()->json(['received' => true]);
    }

}
