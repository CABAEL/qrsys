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

    foreach ($clients as $client) {
        $itemName = trim($client['client_name'] ?? '');

        // 🧩 Map Sloan fields to Monday.com columns
        $columnValues = [
            'text_mkwwy3et' => $client['status'] ?? '',        // Status
            'text_mkwwnfvf' => $client['loan_amount'] ?? '',    // Loan date
            'date_mkwwtchh' => $client['loan_date'] ?? '',    // Loan date
        ];

        // Prepare JSON column values
        $columnValuesJson = json_encode($columnValues);
        $columnValuesEscaped = addslashes($columnValuesJson);

        // Step 2: Check if item already exists (by name)
        $checkQuery = <<<GRAPHQL
        query {
          items_by_column_values(
            board_id: $boardId,
            column_id: "name",
            column_value: "$itemName"
          ) {
            id
            name
          }
        }
        GRAPHQL;

        $checkRes = Http::withHeaders([
            'Authorization' => $mondayApiKey,
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $checkQuery]);

        $existingItems = $checkRes->json()['data']['items_by_column_values'] ?? [];

        // Step 3: Decide whether to update or create
        if (!empty($existingItems)) {
            $itemId = $existingItems[0]['id'];

            $mutation = <<<GRAPHQL
            mutation {
              change_column_values(
                board_id: $boardId,
                item_id: $itemId,
                column_values: "{$columnValuesEscaped}"
              ) {
                id
                name
              }
            }
            GRAPHQL;

            $action = 'Updated';
        } else {
            $mutation = <<<GRAPHQL
            mutation {
              create_item(
                board_id: $boardId,
                item_name: "$itemName",
                column_values: "{$columnValuesEscaped}"
              ) {
                id
                name
              }
            }
            GRAPHQL;

            $action = 'Created';
        }

        // Step 4: Send mutation to Monday.com API
        $res = Http::withHeaders([
            'Authorization' => $mondayApiKey,
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $mutation]);

        Log::info("Item {$action}: {$itemName}", $res->json());
    }

    return response()->json(['success' => true, 'message' => 'Board synced successfully']);
}



}
