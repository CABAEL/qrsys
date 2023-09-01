<?php

namespace App\Http\Controllers;

use App\Models\App_key;
use Illuminate\Http\Request;

class AppkeysController extends Controller
{
    //

    public function apiKeys(){

        return App_key::select('app_keys.*','clients.client_name')->join('clients','clients.client_id','=','app_keys.client_id')
        ->get();
        
    }
}
