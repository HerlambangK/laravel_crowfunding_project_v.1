<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
        {
              $data['user'] = auth()->user();

              return response()->json([
                  'response_code'=> '00',
                  'response_message'=>'profile kamu berhasil di tampilkan',
                  'data'=>$data
              ]);
        }

        public function update(Request $request)
            {
                $user = auth()->user();
                $request->validate([
                        'photo_profile' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
                        ]);

                        
                     if($request->hasFile('photo_profile')){
                      $photo_profile =$request->file('photo_profile');
                      $photo_profile_extension = $photo_profile->getClientOriginalName();
                      $photo_profile_name = \Str::slug($user->name,'-'). '-'.$user->id.".". $photo_profile_extension;
                      $photo_profile_folder = '/photos/user/photo-profile/';

                      $photo_profile_location = $photo_profile_folder . $photo_profile_name;
                      $photo_profile->move(public_path($photo_profile_folder), $photo_profile_name);

                      $user->update([
                          'photo_profile' => $photo_profile_location,
                      ]);
                  }

                  $user->update([
                      'name'=> $request->name,
                  ]);

                  $data['user'] = $user;

                  return response()->json([
                      'response_code'=> '00',
                      'response_message' =>'Selamat, Profil kamu berasil di updated!',
                      'data' => $data
                  ],200);
            }
}