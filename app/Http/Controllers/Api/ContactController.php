<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:190'],
            'subject' => ['required', 'string', 'max:190'],
            'body' => ['required', 'string', 'max:5000'],
            'hp'      => ['nullable', 'string', 'max:50'], 
        ]);

        
        if (!empty($data['hp'])) {
            return response()->json(['ok' => true]);
        }

        $to = config('mail.contact_to', config('mail.from.address'));

        Mail::send('emails.contact', $data, function ($mail) use ($data, $to) {
            $mail->to($to)
                ->replyTo($data['email'], $data['name'])
                ->subject('[Contacto] ' . $data['subject']);
        });

        return response()->json(['ok' => true]);
    }
}
