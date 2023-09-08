<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Client_user;
use App\Models\Service_report;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LogsController extends Controller
{
    //

    public function adminLogView(Request $request){

        $startOfDay = $this->formatDate($request->from) . ' 00:00:00';
        $endOfDay = $this->formatDate($request->to) . ' 23:59:59';

        $query = Service_report::query(); // Create a query builder instance

        if (isset($request->from) && isset($request->to)) {
            $query->whereBetween('created_at', [$startOfDay, $endOfDay]);
        }
        
        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        //return $current_user = Auth::user();
        return view('template.admin.logs',compact('logs'));

    }
    public function clientLogView(Request $request){
        
        $startOfDay = $this->formatDate($request->from) . ' 00:00:00';
        $endOfDay = $this->formatDate($request->to) . ' 23:59:59';

        $select_client_id = Client::where('user_id',Auth::user()->id)->first();

        $select_client_users = Client_user::select('user_id')->where('client_id',$select_client_id->client_id)->get();
        $userIdsArray = $select_client_users->pluck('user_id')->toArray();

        $query = Service_report::query(); // Create a query builder instance

        if (isset($request->from) && isset($request->to)) {
            $query->whereBetween('created_at', [$startOfDay, $endOfDay]);
        }
        $query->where('created_by',Auth::user()->id);
        $query->orWhereIn('created_by',$userIdsArray);

        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        //return $current_user = Auth::user();
        return view('template.client.logs',compact('logs'));

    }

    function formatDate($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }


}
