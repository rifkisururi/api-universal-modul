<?php

namespace App\Jobs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendEmailJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mail;
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            require 'vendor/autoload.php';
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $this->mail['Host'];
            $mail->SMTPAuth = $this->mail['SMTPAuth'];
            $mail->Username = $this->mail['Username'];
            $mail->Password = $this->mail['Password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $this->mail['Port'];
            $mail->setFrom('from@example.com', 'Uji Mailer');
            $mail->addAddress('rifki@mailnesia.com', 'Rfiki');     //Add a recipient
            $mail->addAddress('rifki1@mailnesia.com');               //Name is optional
            $mail->addReplyTo('replay@mailnesia.com', 'Information');
            $mail->isHTML(true);
            //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
