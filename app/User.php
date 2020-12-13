<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UsesUuid;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, UsesUuid;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_user_role_id()
        {
              $role = \App\Role::where('name', 'user')->first();
              return $role->id;
        }

    public static function boot()
        {
                parent::boot();
                static:: creating(function($model){
                    $model->role_id = $model->get_user_role_id();
                });

                static::created(function($model){
                    $model->generate_otp_code();
                });
        }
   

    public function isAdmin()
        {
              if($this->role_id === $this->get_user_role_id()){
                  return false;
              }
              return true;
        }


          public function generate_otp_code()
        {
            //buat angka random
              do{
                  $random = mt_rand(100000,999999);
                  $check = OtpCode::where('otp',$random)->first();
              } while($check);

              $now = Carbon::now();

              //buat otp
              $otp_code = OtpCode::updateOrCreate(
                  ['user_id' => $this->id],
                  ['otp'=> $random, 'valid_until' => $now->addMinute(5)]
              );return $otp_code;
        }
}