<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\sendEmailJob;
use App\Jobs\sendWAJob;

class NotifikasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //use Queueable;

    public function __construct()
    {
        //
    }

    public function sendEmail(Request $request)
    {

        $data['Host'] = $request->host;
        $data['SMTPAuth'] = $request->SMTPAuth;
        $data['Username'] = $request->Username;
        $data['Password'] = $request->Password;
        $data['Port'] = $request->Port;

        dispatch(new sendEmailJob($data));
        return response()->json([
            'meessage' => 'pesan sedang dikirim',
            'status' => true
        ], 200);
    }

    public function sendWA(Request $request)
    {
        $data['dest'] = $request->dest;
        $data['isiPesan'] = $request->isiPesan;
        $data['sender'] = $request->sender;

        dispatch(new sendWAJob($data));
        return response()->json([
            'meessage' => 'pesan sedang dikirim',
            'status' => true
        ], 200);
    }

    public function sendWaLangsung(Request $request)
    {
        //$sender =  "6285161314421";
        $sender = $_GET['sender'];
        $dest = $_GET['dest'];
        $isiPesan = $_GET['isiPesan'];

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
    }
}
