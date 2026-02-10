<?php

namespace App\Http\Controllers\Api;

use App\Models\Band;
use App\Models\User;
use App\Models\Brotherhood;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\OrganizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrganizationApprovedMail;
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

        $token = Str::uuid();

        $user = User::create([
            'name' => $payload['user']['name'],
            'surname' => $payload['user']['surname'] ?? null,
            'email' => $payload['user']['email'],
            'activation_token' => $token,
            'activation_token_expires_at' => now()->addDays(2),
        ]);

        if ($organizationRequest->type === 'band') {
            $organization = Band::create([
                'name' => $payload['organization']['name'],
                'description' => $payload['organization']['description'],
                'city' => $payload['organization']['city'],
                'rehearsal_space' => $payload['organization']['rehearsalPlace'],
                'email' => $payload['organization']['email'],
            ]);

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
        $activationUrl = config('app.frontend_url') . '/activate/' . $token;

        Mail::to($user->email)->send(
            new OrganizationApprovedMail($user, $activationUrl)
        );
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
