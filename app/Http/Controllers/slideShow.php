<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Instagramusers as User;
use App\Instagramlocations as Location;
use App\Instagramphotos as Photo;

class slideShow extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::get()->toArray();
        foreach($photos as &$photo)
        {
          if(isset($photo['instagramlocations_id']) && !empty($photo['instagramlocations_id']))
            $photo['location_data'] = Location::find($photo['instagramlocations_id'])->toArray();

            if(isset($photo['instagramusers_id']) && !empty($photo['instagramusers_id']))
              $photo['user_data'] = User::find($photo['instagramusers_id'])->toArray();
        }
        // echo "<pre>";
        // var_dump($photos);
        // die();
        return view('main')->with('items', $photos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
