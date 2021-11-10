<?php

namespace App\Listeners;

use App\Events\EmailProcessed;
use App\Mail\EmailTemplate;
use Illuminate\Support\Facades\Mail;

class SendEmail
{


    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  EmailProcessed  $event
     * @return void
     */
    public function handle(EmailProcessed $event)
    {
        $emails = $event->emails;
        $driver = $this->getActiveDriver();
        if ($driver){
            foreach ($emails as $email){
                Mail::mailer($driver)
                    ->to($email->receiver)
                    ->send(new EmailTemplate($email));

                if (Mail::failures()) {
                    // change email status to unsent
                }else{
                    // change email status to sent
                }
            }
        }
    }

    private function getActiveDriver()
    {
        $services = config('mail.mailers');
        foreach ($services as $driver => $service){
            try{
                $target = $service['host'];
                $port = $service['port'];
                $error_number = "";
                $error_string = "";
                $timeout = 1;
                $con = fsockopen($target, $port, $error_number, $error_string, $timeout);
                if(!empty($con)) {
                    return $driver;
                }

            }catch (\Exception $e){

            }
        }
        return null;
    }
}
