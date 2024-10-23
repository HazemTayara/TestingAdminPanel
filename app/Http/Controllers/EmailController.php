<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller {

    public function showEmailForm() {
        return view('email.email_form');
    }

    public function sendEmail(Request $request) {
        $request->validate([
            'recipientName' => 'required|string',
            'recipientEmail' => 'required|email',
            'messageContent' => 'required|string'
        ]);

        $recipientName = $request->input('recipientName');
        $recipientEmail = $request->input('recipientEmail');
        $messageContent = $request->input('messageContent');

        Mail::send('email.message', [
            'recipientName' => $recipientName,
            'messageContent' => $messageContent
        ], function ($message) use ($recipientEmail) {
            $message->to($recipientEmail)->subject('رسالة جديدة');
        });

        return back()->with('success', '!.تم إرسال رسالة البريد الإلكتروني بنجاح');
    }
}