<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\AddingQrProcess;

class JobsDispatcherController extends Controller
{
    //

    public function dispatchFiles(){

        dispatch(new AddingQrProcess());
        return "job dispatched!";
    }
}
