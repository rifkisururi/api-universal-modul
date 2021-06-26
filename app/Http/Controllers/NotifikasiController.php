<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\sendEmailJob;

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
            'meessage' => 'kirim email sedang di proses',
            'status' => true
        ], 200);
    }
}
