<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File_upload;
use App\Models\Service_report;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsController extends Controller
{
    public function systemUsageGraph(){

        $data = array(
            'clients' => $this->LoggedInClients(),
            'users' => $this->LoggedInUsers(),
            'file_uploads' => $this->fileUploadWeek(),
            'week' => $this->daysOfWeek()
        );

        return $data;

    }

    public function daysOfWeek(){
        $today = Carbon::now();
        $startDate = $today->copy()->startOfWeek();
        $endDate = $today->copy()->endOfWeek();

        // Create an array of actual dates for each day of the week.
        $daysOfWeek = [];
        for ($i = 1; $i <= 7; $i++) {
            $day = $startDate->copy()->addDays($i - 1);
            $daysOfWeek[] = $day->toDateString();
        }

        return $daysOfWeek;
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

    public function LoggedInClients(){

        $daysOfWeek = $this->daysOfWeek();

        $dayCounts = [];

        foreach ($daysOfWeek as $day) {
            $startOfDay = $day . ' 00:00:00';
            $endOfDay = $day . ' 23:59:59';
        
            $count = Service_report::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('report_name', 'logged_in_client')
            ->count();
        
            $dayCounts[] = $count;
        }

        return $dayCounts;

    }

    public function LoggedInUsers(){

        $daysOfWeek = $this->daysOfWeek();

        $dayCounts = [];

        foreach ($daysOfWeek as $day) {
            $startOfDay = $day . ' 00:00:00';
            $endOfDay = $day . ' 23:59:59';
        
            $count = Service_report::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('report_name', 'logged_in_user')
            ->count();
        
            $dayCounts[] = $count;
        }

        return $dayCounts;

    }

    public function generateClientReport(Request $request)
    {
        
        $startOfDay = $this->formatDate($request->from) . ' 00:00:00';
        $endOfDay = $this->formatDate($request->to) . ' 23:59:59';
        
        $clients = Client::withCount('fileUploads')
            ->orderBy('file_uploads_count', 'desc')
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->get();
        
        // Create a new Spreadsheet instance
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set header styles
        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
        ];
        $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);
        
        // Populate the header row
        $sheet->fromArray(['CLIENT NAME', 'DOCUMENT COUNT', 'CREATED AT'], null, 'A1');
        
        // Populate the sheet with data
        $rowIndex = 2;
        foreach ($clients as $client) {
            $sheet->setCellValue('A' . $rowIndex, $client->client_name);
            $sheet->setCellValue('B' . $rowIndex, $client->file_uploads_count);
            $sheet->setCellValue('C' . $rowIndex, $client->created_at);
            $rowIndex++;
        }
        
        // Auto-size columns after populating data
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Create a writer for the XLSX format
        $writer = new Xlsx($spreadsheet);
        
        // Set the appropriate headers for downloading
        $fileName = 'client_report_' . date('Y_m_d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        
        // Write the spreadsheet content to the output
        $writer->save('php://output');
        
        

        
    }
    public function clientReports(Request $request)
    {
        $startOfDay = $this->formatDate($request->from) . ' 00:00:00';
        $endOfDay = $this->formatDate($request->to) . ' 23:59:59';

        $clients = Client::withCount('fileUploads')
        ->orderBy('file_uploads_count', 'desc');
    
        if (isset($request->from) && isset($request->to)) {
            $clients->whereBetween('created_at', [$startOfDay, $endOfDay]); // Changed $request->from to $request->to
        }
        
        $clients = $clients->paginate(10);
    
        $clientNames = $clients->pluck('client_name');
        $uploadCounts = $clients->pluck('file_uploads_count');
    
        return view('template.iframe_views.reports.client_report',compact('clients','clientNames','uploadCounts'));
        
    }

    function formatDate($date) {
        return Carbon::parse($date)->format('Y-m-d');
    }

}
