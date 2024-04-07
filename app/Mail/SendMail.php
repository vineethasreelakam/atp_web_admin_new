<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use SendGrid;
use SendGrid\Mail\Mail;

class SendMail extends Mailable
{

    public static function sendemail($to_data = "", $subject = "", $content = "")
    {
        $apiKey = env('SENDGRID_API_KEY');
        $email_from = env('EMAIL_FROM');
        $email_from_name = env('EMAIL_FROM_NAME');

        $email = new Mail();
        $email->setFrom($email_from, $email_from_name);
        $email->setSubject($subject);
        $email->addTo($to_data['to_email'], $to_data['name']);

        // Add the rendered content to the email
        $email->addContent("text/html", $content);

        $sendgrid = new SendGrid($apiKey);
        try {
            $response = $sendgrid->send($email);
            return true;
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
        
    }
}

?>