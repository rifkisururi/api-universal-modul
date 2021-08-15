<?php

namespace App\Jobs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendWAJob2 extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sender =  "D".$this->data['sender'];
        $dest = $this->data['dest'];
        $isiPesan = str_replace("<br>","/n",$this->data['isiPesan']);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://warifki.herokuapp.com/send-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'number='.$dest.'&message='.$isiPesan.'&sender='.$sender,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

        // tambahkan status pengiriman, jika berhasil, status pesan sukses, jika gagal, ulangi 1 menit kemudian
    }
}
