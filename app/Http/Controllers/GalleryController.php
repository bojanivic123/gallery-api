<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input("name");
        $query = Gallery::query();

        if ($name) {
            $query->search($name);
        }

        $galleries = $query->with("user")->orderBy("created_at", "DESC")->paginate(10);
        return $galleries;  
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGalleryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->urls = json_encode($request->urls);
        $gallery->user_id = $request->user_id;
        $gallery->save();
        return $gallery; 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::with("user", "comments")->find($id);
        return $gallery; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGalleryRequest  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->urls = json_encode($request->urls);
        $gallery->save();
        return $gallery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return true; 
    }
}

