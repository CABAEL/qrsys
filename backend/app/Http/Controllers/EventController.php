<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Event::orderBy('created_at','DESC')->get();
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

        $validate_request = $request->validate([
            'event_name' => 'required',
            'event_date' => 'required',
            'event_description' => 'required',
        ]);

        $qry = Event::create([
            'created_by' => Auth::user()->id,
            'title' => $validate_request['event_name'],
            'date' => $validate_request['event_date'],
            'description' => $validate_request['event_description'],
        ]);

        if($qry){
            $response = [
                'flag' => 1,
                'message' => 'Event successfully created!'
            ];
        }
        return $response;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       return  Event::where('id',$id)->get();
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

 
        $validate_request = $request->validate([
            'event_name' => 'required',
            'event_date' => 'required',
            'event_description' => 'required',
            'event_id' => 'required',
        ]);

        $id = $request->event_id;

        $qry = Event::where('id',$id)->update([
            'title' => $validate_request['event_name'],
            'date' => $validate_request['event_date'],
            'description' => $validate_request['event_description'],
        ]);

        if($qry){
            $response = [
                'flag' => 1,
                'message' => 'Event updated successfully!'
            ];
        }
        return $response;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Event::where('id',$id)->delete();

    }
}
