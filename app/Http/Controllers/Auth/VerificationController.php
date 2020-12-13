<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'otp'=>'required'
        ]);

        //cari otp
        $otp_code= OtpCode::where('otp', $request->otp)->first();

        //kalau otp ga ketemu
        if(!$otp_code){
            return response()->json([
                'response_code' => '404',
                'response_message' => 'Kode Otp kamu tidak di temukan'
            ],200);
        }

        $now = Carbon::now();
        //cek kedaluarsa otp
        if($now > $otp_code->valid_until){
             return response()->json([
                'response_code' => '01',
                'response_message' => 'Kode otp kamu terlalu lama, silahkan generate ulang .'
            ],200);
        }

        //update user otp di users
       $user = User::find($otp_code->user_id);
        // dd($user);
        $user->email_verified_at = Carbon::now();
        $user->save();


        $data['user'] =$user;

        return response()->json([
                'response_code' => '200',
                'response_message' => 'Selamat Akun anda telah terverifikasi',
                'data'=>$user
            ],200);
        
    }
}