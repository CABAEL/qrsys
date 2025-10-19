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

    // Step 2: Fetch existing items on the Monday board
    $query = <<<GRAPHQL
    query {
        boards(ids: $boardId) {
            items {
                id
                name
            }
        }
    }
    GRAPHQL;

    $existingItemsRes = Http::withHeaders([
        'Authorization' => $mondayApiKey,
        'Content-Type' => 'application/json',
    ])->post($mondayApiUrl, ['query' => $query]);

    $existingItems = $existingItemsRes->json()['data']['boards'][0]['items'] ?? [];

    $existingNames = [];
    foreach ($existingItems as $item) {
        $existingNames[$item['name']] = $item['id'];
    }

    // Step 3: Loop through clients and upsert
    foreach ($clients as $client) {
        $itemName = trim("{$client['client_name']}");

        $columnValues = [
            'color_mkwwdrf8' => ['label' => $client['status']], // Status column
            'date_mkwwtchh'  => $client['loan_date'] ?? '',      // Loan date
            'text_mkwwnfvf'  => $client['loan_amount'] ?? '',    // Loan amount
        ];

        $columnValuesEscaped = addslashes(json_encode($columnValues));

        if (isset($existingNames[$itemName])) {
            // Update existing item
            $itemId = $existingNames[$itemName];
            $mutation = <<<GRAPHQL
            mutation {
                change_column_values(item_id: $itemId, board_id: $boardId, column_values: "$columnValuesEscaped") {
                    id
                    name
                }
            }
            GRAPHQL;
        } else {
            // Create new item
            $mutation = <<<GRAPHQL
            mutation {
                create_item(board_id: $boardId, item_name: "$itemName", column_values: "$columnValuesEscaped") {
                    id
                    name
                }
            }
            GRAPHQL;
        }

        $res = Http::withHeaders([
            'Authorization' => $mondayApiKey,
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $mutation]);

        Log::info("Upserted Item: {$itemName}", $res->json());
    }

    return response()->json(['success' => true, 'message' => 'Board synced successfully']);
}


}
