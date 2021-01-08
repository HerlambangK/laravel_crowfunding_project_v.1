<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function random($count)
            {
                  $blogs = Blog::select('*')
                            ->inRandomOrder()
                            ->limit($count)
                            ->get();
                $data['blogs'] = $blogs;

                return response()->json([
                    'response_code' => '00',
                    'response_message' => 'data Blog berhasil di tampilkan',
                    'data' => $data
                ],200);
            }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        $blogs = Blog::create([
            'title' =>$request->title,
            'description' => $request->description
        ]);
        
        // $data['campaigns'] = $campaign;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $blogs->id.".". $image_extension;
            $image_folder = '/photos/blog/';

            $image_location = $image_folder . $image_name;
            // $image->move(public_path($image_folder), $image_name);

          try{
              $image->move(public_path($image_folder), $image_name);
              $blogs->update([
                  'image'=> $image_location,
              ]);
              
          } catch ( \Exception $e) {
              return response()->json([
                  'response_code'=> '01',
                  'response_message'=>'photo profile gagal upload',
                  'data' => $data
              ],200);
          }
        }
        $data['blogs'] = $blogs;
         return response()->json([
                    'response_code' => '00',
                    'response_message' => 'data campaign berhasil di tambahkan',
                    'data' => $data
                ],200);
    }


}