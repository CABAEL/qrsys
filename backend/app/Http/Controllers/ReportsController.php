<?php

namespace App\Http\Controllers;

use App\Models\File_upload;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function systemUsageGraph(){

        $today = Carbon::now();
        $startDate = $today->copy()->startOfWeek();
        $endDate = $today->copy()->endOfWeek();

        // Create an array of actual dates for each day of the week.
        $daysOfWeek = [];
        for ($i = 1; $i <= 7; $i++) {
            $day = $startDate->copy()->addDays($i - 1);
            $daysOfWeek[] = $day->toDateString();
        }

        $data = array(
            'client' => [],
            'users' => [],
            'file_uploads' => $this->fileUploadWeek(),
            'week' => $daysOfWeek
        );

        return $data;

    }

    public function fileUploadWeek(){

        // Get the start and end dates of the current week (assuming today is Sunday).
        $today = Carbon::now();
        $startDate = $today->copy()->startOfWeek();
        $endDate = $today->copy()->endOfWeek();

        // Fetch records for the current week.
        $uploads = File_upload::whereBetween('created_at', [$startDate, $endDate])->get();
        

        // Initialize an array to store daily sums.
        $dayCounts = array_fill(1, 7, 0); // Initialize with 7 days and 0 value.

        // Group records by day and calculate sums.
        foreach ($uploads as $upload) {
            $dayOfWeek = $upload->created_at->dayOfWeek; // 1 (Monday) to 7 (Sunday)
            $dayCounts[$dayOfWeek]++;
        }
        
        // Convert the counts to the desired array format.
        $dailyCountsArray = array_values($dayCounts);

        return $dailyCountsArray;

    }
}
