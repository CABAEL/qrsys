<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return announcement::orderBy('created_at','DESC')->get();
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
        $validate_request = $request->validate([
            'announcement_name' => 'required',
            'announcement_description' => 'required',
        ]);

        $qry = announcement::create([
            'created_by' => Auth::user()->id,
            'title' => $validate_request['announcement_name'],
            'description' => $validate_request['announcement_description'],
        ]);

        if($qry){
            $response = [
                'flag' => 1,
                'message' => 'Announcement successfully created!'
            ];
        }
        return $response;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return announcement::where('id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validate_request = $request->validate([
            'announcement_id' => 'required',
            'announcement_name' => 'required',
            'announcement_description' => 'required',
        ]);

        $id = $request->announcement_id;

        $qry = announcement::where('id',$id)->update([
            'title' => $validate_request['announcement_name'],
            'description' => $validate_request['announcement_description'],
        ]);

        if($qry){
            $response = [
                'flag' => 1,
                'message' => 'Announcement updated successfully!'
            ];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return announcement::where('id',$id)->delete();
    }
}
