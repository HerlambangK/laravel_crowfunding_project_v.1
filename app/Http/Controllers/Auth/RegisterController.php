<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;


class RegisterController extends Controller
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
            'name'=>['string','required'],
            'username'=>['alpha_num','required', 'min:3','max:25','unique:users,username'],
            'email'=>['email','required','unique:users,email'],
            'password'=>['required','min:6'],
            ]);

            $data=[];

            $user = User::create([
                'name' => request('name'),
                'username' => request('username'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                // 'password' => decrypt(request('password')),
            ]);
             $data['user']= $user;
             

            event(new UserRegisteredEvent($user , 'register'));

            return response()->json([
                'response' =>'00',
                'message'=>' Thanks, Kamu baru mendaftar, Silahkan kirimkan kode otp untuk verifikasi',
                'data'=>$data

            ],200);
            
    }
}