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

    if (!isset($data['clients']) || !is_array($data['clients'])) {
        return response()->json(['error' => 'Invalid Sloan API structure'], 400);
    }

    $clients = $data['clients'];

    if (empty($clients)) {
        return response()->json(['error' => 'No clients found in Sloan API'], 400);
    }

    // Step 2: Loop through clients and insert into Monday board
    foreach ($clients as $client) {
        $itemName = "{$client['firstname']} {$client['lastname']}";

        // 🧩 Correctly map Sloan fields to Monday.com column IDs
        $columnValues = [
            'name' => $client['firstname'] . $client['middlename'] ?? ''. $client['lastname'] ,
            'color_mkwwdrf8' => [
                'label' => $client['status'] // or 'unpayed'
            ],
            'date_mkwwtchh' => $client['loan_date'] ?? '',
            'text_mkwwnfvf' => $client['loan_amount']   // Loan date
        ];

        // Encode to JSON and escape for GraphQL
        $columnValuesEscaped = addslashes(json_encode($columnValues));

        $mutation = <<<GRAPHQL
        mutation {
            create_item (
                board_id: $boardId,
                item_name: "$itemName",
                column_values: "$columnValuesEscaped"
            ) {
                id
                name
            }
        }
        GRAPHQL;

        // Step 3: Send mutation to Monday.com API
        $res = Http::withHeaders([
            'Authorization' => $mondayApiKey,
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $mutation]);

        Log::info("Item Created: {$itemName}", $res->json());
    }

    return response()->json(['success' => true, 'message' => 'Board synced successfully']);
}

}
