<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
        {
              $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

              return response()->json([
                  'url' =>$url
              ]);
            // dd("hallo");
        }

        public function handleProviderCallback($provider)
            {
                  try{
                      $social_user = Socialite::driver($provider)->stateless()->user();
                    //   dd($social_user->user['given_name']);
                      if (!$social_user){
                          return response()->json([
                                'response_code' => '401',
                                'response_message' => 'Login Failed gada social user',
                            ],401);
                      }

                    $user = User::whereEmail($social_user->email)->first();
                    // dd($user);
                    if(!$user){
                        if($provider == 'google'){
                            $photo_profile = $social_user->avatar;
                        }
                        
                        $user = User::create([
                            'email'=> $social_user->email,
                            'name'=> $social_user->name,
                            'username' =>$social_user->user['given_name'],
                            'email_verified_at'=> Carbon::now(),
                            'photo_profile'=> $photo_profile
                        ]);

                        dd($user);
                        dd($provider);
                        dd($photo_profile);
                    }

                    $data['user'] = $user;
                    $data['token'] = auth()->login($user);
                    return response()->json([
                                'response_code' => '00',
                                'response_message' => 'User Berhasil Login',
                                'data' => $data
                            ],200);

                  } 
                  catch(\Throwable $th){
                             return response()->json([
                                'response_code' => '401',
                                'response_message' => 'Login Failed gagal buat user',
                            ],401);
                            
                  }
            }
}