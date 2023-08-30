<?php

namespace App\Http\Controllers;

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

    function formatDate($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }


}
