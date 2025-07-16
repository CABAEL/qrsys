<?php

namespace App\Http\Controllers;

use App\Models\File_upload;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;


use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use setasign\Fpdi\PdfParser\StreamReader;
use Symfony\Component\Process\PhpProcess;


class PDFController extends Controller
{
    public function showPdfQr()
    {
        $filename = "3123_6_1688927000_filessss.pdf";
        $source_file = storage_path('tmp').'/'.$filename;
        $output_file = storage_path('app/public/'.env('CLIENT_DIR_PATH').'').$filename;
        
        $validate = $this->checkPdfVersion($source_file);
    
        if ($validate) {
            $this->addQr($source_file, $output_file);
            File::delete($source_file);
        } else {
            // Ghostscript
            $sc_output_file = storage_path('app/public/'.env('CLIENT_DIR_PATH').'').'SC_'.time().'_'.$filename;
    
            $command = sprintf('gswin64.exe -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -o %s %s', $sc_output_file, $source_file);
            exec($command,$output,$returnCode);
    
            if ($returnCode === 0) {
                // // Add QR code to the modified PDF
                $this->addQr($sc_output_file, $output_file);
               
            }
        }
    }

    public function addQrDummy(){
        
        $source_file = "D:\projects\qrsys\backend\storage"."\\"."tmp\AWS_6_1691251921_test.pdf";
        $outputFilePath = "uploads/system_files/clients_directory/a646bfa30bb128934e812f1ab43654b3/file_uploads/AWS_6_1691251921_test.pdf";
        $pdf = new Fpdi();

        $totalPages = $pdf->setSourceFile($source_file);
        
        for ($pageNo = 1; $pageNo <= $totalPages; $pageNo++) {
            // Import the current page
            $templateId = $pdf->importPage($pageNo);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
    
            // Set the watermark image
            $file_upload_data = File_upload::where('id',23)->first();

            $watermarkImagePath = 'data:image/png;base64,' . $file_upload_data->blob_qr;
    
            $pageWidth = $pdf->getPageWidth() * (97 / 100);
            $pageHeight = $pdf->getPageHeight() * (97 / 100);
    
            // Determine the available width and height of the PDF viewer's layout
            $availableWidth = $pageWidth;
            $availableHeight = $pageHeight;
    
            // Define the maximum width and height for the watermark image
            $maxWidth = 15;
            $maxHeight = 15;
    
            // Calculate the scale factor for resizing the watermark image
            $scaleWidth = $availableWidth / $maxWidth;
            $scaleHeight = $availableHeight / $maxHeight;
            $scaleFactor = min($scaleWidth, $scaleHeight);
    
            // Calculate the new width and height for the watermark image
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
    
            // Calculate the new position for the watermark image
            $newX = $pageWidth - $newWidth;
            $newY = $pageHeight - $newHeight;
    
            // Display the adjusted watermark image
            $pdf->Image($watermarkImagePath, $newX, $newY, $newWidth, $newHeight,'png');

        }
    
        if($pdf->Output($outputFilePath, 'F')){
            return true;
        }
        return false;
    
        // Optionally, you can return a response or redirect to the generated PDF file.
    }    

    public function addQr($source_file,$outputFilePath){
        
        $pdf = new Fpdi();

        $totalPages = $pdf->setSourceFile($source_file);
        
        for ($pageNo = 1; $pageNo <= $totalPages; $pageNo++) {
            // Import the current page
            $templateId = $pdf->importPage($pageNo);
            $pdf->addPage();
            $pdf->useTemplate($templateId);
    
            // Set the watermark image
            $file_upload_data = File_upload::where('id',28)->first();

            $watermarkImagePath = 'data:image/png;base64,' . $file_upload_data->blob_qr;
    
            $pageWidth = $pdf->getPageWidth() * (97 / 100);
            $pageHeight = $pdf->getPageHeight() * (97 / 100);
    
            // Determine the available width and height of the PDF viewer's layout
            $availableWidth = $pageWidth;
            $availableHeight = $pageHeight;
    
            // Define the maximum width and height for the watermark image
            $maxWidth = 15;
            $maxHeight = 15;
    
            // Calculate the scale factor for resizing the watermark image
            $scaleWidth = $availableWidth / $maxWidth;
            $scaleHeight = $availableHeight / $maxHeight;
            $scaleFactor = min($scaleWidth, $scaleHeight);
    
            // Calculate the new width and height for the watermark image
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
    
            // Calculate the new position for the watermark image
            $newX = $pageWidth - $newWidth;
            $newY = $pageHeight - $newHeight;
    
            // Display the adjusted watermark image
            $pdf->Image($watermarkImagePath, $newX, $newY, $newWidth, $newHeight,'png');

        }
    
        if($pdf->Output($outputFilePath, 'F')){
            return true;
        }
        return false;
    
        // Optionally, you can return a response or redirect to the generated PDF file.
    }

    public function checkPdfVersion($filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new Exception("File does not exist or cannot be read.");
        }

        $pdfContent = file_get_contents($filePath);
        $hasVersionIndicator = strpos($pdfContent, '1.4') !== false;

        return !$hasVersionIndicator;
    }


    public function mergePDFs()
    {
        $pdf = new Fpdi();

        $files = [
            public_path('test/1.pdf'),
            public_path('test/2.pdf'),
            // Add additional file paths here
        ];

        foreach ($files as $file) {
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo, '/MediaBox');
                $pdf->addPage();
                $pdf->useTemplate($templateId);
            }
        }

        $outputFilename = '';

        $pdf->Output(public_path('test/merged.pdf'), 'F');

        //return response()->download($outputFilename)->deleteFileAfterSend();
    }


    public function generateQrCode()
    {
        $cr_code_value = 'Mark V';
        $logopath = public_path('test/1.png');

        $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($cr_code_value)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->logoPath($logopath)
        ->logoResizeToWidth(50)
        ->logoPunchoutBackground(true)
        ->labelText('QRDOCX')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->validateResult(false)
        ->build();

        $imageData = $result->getString();
        $blobData = base64_encode($imageData);


        
        $file = File_upload::where('id','18')->update([
            'blob_qr' => $blobData
        ]);

        $select = File_upload::where('id','27')->first();

        header("Content-Type: image/png");
        echo base64_decode($select->blob_qr);

        

        // Save the blob data in the database
        //Storage::disk('public')->put('qrtest.png', $blobData);

        //$result->saveToFile(public_path('test/qrtest.png'));
    }
}
