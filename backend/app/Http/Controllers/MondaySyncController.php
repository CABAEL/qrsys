<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MondaySyncController extends Controller
{
    public function sync()
    {
        $sloanApiUrl = 'https://abbynavarro.github.io/Abby.github.io/api/';
        $mondayApiUrl = 'https://api.monday.com/v2';
        $mondayApiKey = env('MONDAY_API_KEY');
        $boardId = env('MONDAY_BOARD_ID');

        // Step 1: Get Sloan data
        $response = Http::get($sloanApiUrl);
        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch from Sloan API'], 500);
        }

        $data = $response->json();

        if (!isset($data['clients']) || !is_array($data['clients']) || empty($data['clients'])) {
            return response()->json(['error' => 'No clients found in Sloan API'], 400);
        }

        $clients = $data['clients'];

        foreach ($clients as $client) {
            $itemName = addslashes(trim($client['client_name'] ?? 'Unnamed Client'));

            $columnValues = [
                'text_mkwwy3et' => $client['status'] ?? '',       // Status
                'text_mkwwnfvf' => (string) ($client['loan_amount'] ?? ''), // Loan Amount
                'date_mkwwtchh' => $client['loan_date'] ?? '',    // Loan Date
            ];

            $columnValuesJson = json_encode($columnValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $mutation = <<<GRAPHQL
            mutation {
            create_item(
                board_id: {$boardId},
                item_name: "{$itemName}",
                column_values: "{$columnValuesJson}"
            ) {
                id
                name
            }
            }
            GRAPHQL;

            $res = Http::withHeaders([
                'Authorization' => $mondayApiKey,
                'Content-Type' => 'application/json',
            ])->post($mondayApiUrl, ['query' => $mutation]);

            Log::info("Created Item: {$itemName}", $res->json());
        }


        return response()->json(['success' => true, 'message' => 'All items created successfully']);
    }
}
