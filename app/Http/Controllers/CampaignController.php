<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function random($count)
            {
                  $campaigns = Campaign::select('*')
                            ->inRandomOrder()
                            ->limit($count)
                            ->get();
                $data['campaigns'] = $campaigns;

                return response()->json([
                    'response_code' => '00',
                    'response_message' => 'data campaign berhasil di tampilkan',
                    'data' => $data
                ],200);
            }

                /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        $campaign = Campaign::create([
            'title' =>$request->title,
            'description' => $request->description
        ]);
        
        // $data['campaigns'] = $campaign;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $campaign->id.".". $image_extension;
            $image_folder = '/photos/campaign/';

            $image_location = $image_folder . $image_name;
            // $image->move(public_path($image_folder), $image_name);

          try{
              $image->move(public_path($image_folder), $image_name);
              $campaign->update([
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
        $data['campaigns'] = $campaign;
         return response()->json([
                    'response_code' => '00',
                    'response_message' => 'data campaign berhasil di tambahkan',
                    'data' => $data
                ],200);
    }

            
    public function index()
    {
        $campaigns = Campaign::paginate(2);

        $data['campaigns'] = $campaigns;
            return response()->json([
                    'response_code' => '00',
                    'response_message' => 'data campaign berhasil di tambahkan',
                    'data' => $data
                ],200);
    }


    public function detail($id)
        {
            $campaign = Campaign::find($id);
            $data['campaign']=$campaign;

            return response()->json([
            'response_code' => '00',
            'response_message' => 'data campaign berhasil di tampilkan',
            'data' => $data
                ],200);
        }


  
}