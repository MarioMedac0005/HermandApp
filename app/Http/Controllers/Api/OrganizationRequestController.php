<?php

namespace App\Http\Controllers\Api;

use App\Models\Band;
use App\Models\User;
use App\Models\Brotherhood;
use Illuminate\Support\Facades\DB;
use App\Models\OrganizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\OrganizationRejectedMail;
use App\Http\Requests\ReviewOrganizationRequest;
use App\Http\Resources\OrganizationRequestResource;

class OrganizationRequestController extends Controller
{
    /**
     * Listado de solicitudes
     */
    public function index()
    {
        $requests = OrganizationRequest::latest()->paginate(20);

        return OrganizationRequestResource::collection($requests);
    }

    /**
     * Ver detalle de una solicitud
     */
    public function show(OrganizationRequest $organizationRequest)
    {
        return new OrganizationRequestResource($organizationRequest);
    }

    /**
     * Aprobar o rechazar una solicitud
     */
    public function update(ReviewOrganizationRequest $request, OrganizationRequest $organizationRequest)
    {
        if ($organizationRequest->status !== 'pending') {
            return response()->json([
                'message' => 'Esta solicitud ya ha sido procesada.'
            ], 409);
        }

        DB::transaction(function () use ($request, $organizationRequest) {

            if ($request->status === 'approved') {
                $this->approve($organizationRequest);
            } else {
                $this->reject($organizationRequest, $request->admin_notes);
            }

            $organizationRequest->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        return new OrganizationRequestResource($organizationRequest->fresh());
    }

    /**
     * Lógica de aprobación
     */
    protected function approve(OrganizationRequest $organizationRequest): void
    {
        $payload = $organizationRequest->payload;

        $user = User::create([
            'name' => $payload['user']['name'],
            'surname' => $payload['user']['surname'] ?? null,
            'email' => $payload['user']['email'],
        ]);

        if ($organizationRequest->type === 'band') {
            $organization = Band::create([
                'name' => $payload['organization']['name'],
                'description' => $payload['organization']['description'],
                'city' => $payload['organization']['city'],
                'rehearsal_space' => $payload['organization']['rehearsalPlace'],
                'email' => $payload['organization']['email'],
            ]);

            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $account = $stripe->accounts->create([
                    'type' => 'express',
                    'country' => 'ES', // Cambia según tu país
                    'email' => $organization->email,
                    'business_type' => 'company',
                    'company' => [
                        'name' => $organization->name,
                    ],
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                ]);

                // Guardar el stripe_account_id en la banda
                $organization->stripe_account_id = $account->id;
                $organization->stripe_onboarding_completed = false;
                $organization->save();

            } catch (\Exception $e) {
                // Manejo de error: puedes registrar o enviar notificación
                report($e);
                // Opcional: decidir si cancelar la creación de la banda o dejarla sin Stripe
            }

            $user->band_id = $organization->id;
        }

        if ($organizationRequest->type === 'brotherhood') {
            $organization = Brotherhood::create([
                'name' => $payload['organization']['name'],
                'city' => $payload['organization']['city'],
                'office' => $payload['organization']['canonicalSeat'],
                'phone_number' => $payload['organization']['phone'],
                'email' => $payload['organization']['email'],
            ]);

            $user->brotherhood_id = $organization->id;
        }

        $user->save();
        $user->assignRole('gestor');

        Password::sendResetLink(['email' => $user->email]);
    }

    /**
     * Lógica de rechazo
     */
    protected function reject(OrganizationRequest $organizationRequest, ?string $adminNotes): void
    {
        $email = $organizationRequest->payload['user']['email'];

        $retryUrl = config('app.frontend_url') . '/register';

        Mail::to($email)->send(
            new OrganizationRejectedMail($organizationRequest, $adminNotes, $retryUrl)
        );
    }
}
