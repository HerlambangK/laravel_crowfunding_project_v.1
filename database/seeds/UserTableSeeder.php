<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        $faker =Faker\Factory::create();
        for($i=0; $i<3; $i++){
            $avatar_path = 'public/photos/user';
            $avatar_fullpath =$faker->image($avatar_path,200,250, 'people', true,true,'people');
            $avatar_image = explode("\\", $avatar_fullpath);
            $users[$i]=[
                'id' => Str::uuid(),
                'role_id' => 'a27487df-fb1e-4809-80f2-44ee8429aac8',
                'name'=> $faker->name,
                'email' =>$faker->unique()->safeEmail,
                'password'=>bcrypt('123456'),
                'username'=> $faker->username,
                'photo_profile' => 'photos/user/'.$avatar_image[1],
                'created_at'=> \Carbon\Carbon::now()
            ];
        }
        DB::table('users')->insert($users);
    
    }
}