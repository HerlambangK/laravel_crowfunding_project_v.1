<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CampaignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campaigns = [];
        $faker = Faker\Factory::create();
        for($i=0; $i<3; $i++){
            $avatar_path = '/photos/user/photo-profile';
            $avatar_fullpath =$faker->image($avatar_path,200,250, 'people', true,true,'people');
            $avatar_image = explode('\\', $avatar_fullpath);
            $campaigns[$i]=[
                'title'=> $faker->title,
                'description' =>$faker->text,
                'image' => '/photos/campaigns/'.$avatar_image[0],
                'created_at'=> \Carbon\Carbon::now()
            ];
        }
        DB::table('campaigns')->insert($campaigns);
    }
}