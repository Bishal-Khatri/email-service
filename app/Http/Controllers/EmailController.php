<?php

namespace App\Http\Controllers;

use App\Events\EmailProcessed;
use App\Models\Email;
use App\Models\User;
use App\Traits\SetResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class EmailController extends Controller
{
    use setResponse;
    public function inbox()
    {
        return json_encode(Email::all());
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'sender' => 'required|email',
            'receiver' => 'required|array',
            'receiver.*' => 'required|email|distinct',
            'subject' => 'required',
            'body' => 'required',
        ]);
        $receivers = $request->receiver;

        if (!blank($receivers)){
            $emails = [];
            foreach ($receivers as $receiver){
                $email = new Email();
                $email->sender = $request->sender;
                $email->receiver = $receiver;
                $email->subject = $request->subject;
                $email->body = $request->body;
                $email->save();
                $emails[] = $email;
            }
            \event(new EmailProcessed( $emails));
            $response = $this->prepareResponse(false, 'success', [], []);
            return response()->json($response);
        }
    }
}
