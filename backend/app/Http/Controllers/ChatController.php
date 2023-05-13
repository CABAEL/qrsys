<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $id = Auth::user()->id;

        return chat::join('users','users.id','=','chats.from')
        ->whereRaw('chats.from = '.$id.' AND chats.to = 1 OR chats.from = 1 AND chats.to = '.$id.'')
        ->orderBy('chats.id','DESC')
        ->get();
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
        $id = Auth::user()->id;

        if(isset($request->to_id)){
            
            $validated_request = $request->validate([
                'msg' => 'required',
            ]);
    
            $qry = chat::create([
                'from' => $id,
                'to' => $request->to_id,
                'msg' => $validated_request['msg'],
            ]);

        }else{
            

            $validated_request = $request->validate([
                'msg' => 'required',
            ]);
    
            $qry = chat::create([
                'from' => $id,
                'to' => 1,
                'msg' => $validated_request['msg'],
            ]);
    
        }

        if($qry){

            return $data = [
                'message' => 'Msg Sent!',
                'status' => 1,
            ];

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$id = Auth::user()->id;
        return chat::join('users','users.id','=','chats.from')
        ->whereRaw('chats.from = '.$id.' AND chats.to = 1 OR chats.from = 1 AND chats.to = '.$id.'')
        ->orderBy('chats.id','DESC')
        ->get();
    }

    public function updateMsgsStatus($id)
    {
        //return $id;
        return chat::where('from',$id)->update(['status'=>1]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(chat $chat)
    {
        //
    }

    public function getAdminChats()
    {
        $id = Auth::user()->id;

        $chats = DB::table('chats')
        ->select('from', DB::raw('count(*) as total'))
        ->where('to',$id)
        ->groupBy('from')
        ->get();

        $data = array();
        foreach($chats as $chat){


            $user = User::where('id',$chat->from)->get();
            $chat = Chat::where('to',$id)
            ->where('from',$user[0]['id'])
            ->orderBy('created_at','DESC')
            ->limit(1)->get();

            $data[] = [
                'user' => $user[0]['username'],
                'user_id' => $user[0]['id'],
                'chat' => $chat
            ];

            //sort($data['chat']['created_at']);
            
        }   

        return $data;
    }
}
