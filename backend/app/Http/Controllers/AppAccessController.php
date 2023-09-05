<?php

namespace App\Http\Controllers;

use App\Models\App_key;
use App\Models\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppAccessController extends Controller
{
    public function addAccessKey(Request $request){

        $current_user = Auth::user();

        $validator = Validator::make($request->all(), [
            'select_client' => 'required',
            'appkey' => 'required|numeric', // Requires only numeric characters
            'appsecret' => 'required',
            'description' => 'required|string',
        ]);

        $validator->messages()->add('select_client', 'The bind to client field is required!'); 
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $create_key = App_key::create([
            'client_id' => $request->select_client,
            'appkey' => $request->appkey,
            'appsecret' => $request->appsecret,
            'description' => $request->description,
            'created_by' => $current_user->id
        ]);

        if($create_key){

            $message = "[".strtoupper($current_user->role).'] : ['.Auth::user()->id.'] has created new api access for client_id: ['.$request->select_client.']';
            Base::serviceInfo($message,Base::ADD_CLIENT_API_ACCESS,$create_key);
            return responseBuilder('Success','Added successfully.',[],$create_key);
            
        }

        return false;

    }

    public function apiKeys(){

        return App_key::select('app_keys.*','clients.client_name')->join('clients','clients.client_id','=','app_keys.client_id')
        ->get();
        
    }

    public function showAppKey($id){

        return App_key::select('app_keys.*','clients.client_name')
        ->join('clients','clients.client_id','=','app_keys.client_id')
        ->where('id',$id)
        ->first();
        
    }
    public function updateAppKey(Request $request,$id){

        $current_user = Auth::user();

        $validator = Validator::make($request->all(), [
            'edit_appkey' => 'required|numeric',
            'edit_appsecret' => 'required',
            'edit_description' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $update_key = App_key::where('id',$id)->update([
            'appkey' => $request->edit_appkey,
            'appsecret' => $request->edit_appsecret,
            'description' => $request->edit_description,
        ]);

        if($update_key){

            $message = "[".strtoupper($current_user->role).'] : ['.Auth::user()->username.': '.Auth::user()->id.'] has updated API ACCESS KEY ID: ['.$id.']';
            Base::serviceInfo($message,Base::UPDATE_CLIENT_API_ACCESS,[
                'appkey' => $request->edit_appkey,
                'appsecret' => $request->edit_appsecret,
                'description' => $request->edit_description,
            ]);
            return responseBuilder('Success','Saved successfully!',[],$update_key);
            
        }

        
    }

    public function destroy($id){

        $current_user = Auth::user();

        $delete = App_key::find($id);
        $delete->delete();

        if($delete){

            $data = [
                'id' => 1,
                'message' => "Access deleted!"
            ];

            $message = "[".strtoupper($current_user->role).'] : ['.Auth::user()->username.': '.Auth::user()->id.'] has deleted API ACCESS KEY ID: ['.$id.']';
            Base::serviceInfo($message,Base::UPDATE_CLIENT_API_ACCESS,$id);

            return responseBuilder('Success','Deleted successfully!',[],$data);
        }

        return false;


        
    }

}
