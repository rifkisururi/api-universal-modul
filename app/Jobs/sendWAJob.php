<?php

namespace App\Jobs;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendWAJob extends Job
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
        $sender =  $this->data['sender'];
        $dest = $this->data['dest'];
        $isiPesan = $this->data['isiPesan'];

        // masukan data pengiriman pesan ke log

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://whapi.io/api/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"app\": {\r\n    \"id\": \"$sender\",\r\n    \"time\": \"1605326773\",\r\n    \"data\": {\r\n      \"recipient\": {\r\n        \"id\": \"$dest\"\r\n      },\r\n      \"message\": [\r\n        {\r\n          \"time\": \"1605326773\",\r\n          \"type\": \"text\",\r\n          \"value\": \"$isiPesan\"\r\n        }\r\n      ]\r\n    }\r\n  }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "Cookie: __cfduid=d424776e2d5021b158f1e64c99f2d7fce1604293254; ci_session=3b712ap59vc924a9o15j5rti70gif6k0"
            ),
        ));

        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);
        echo $response;

        // tambahkan status pengiriman, jika berhasil, status pesan sukses, jika gagal, ulangi 1 menit kemudian
    }
}
