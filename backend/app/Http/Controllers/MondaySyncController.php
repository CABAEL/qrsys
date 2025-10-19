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

    // Step 1: Fetch Sloan data
    $response = Http::get($sloanApiUrl);
    if ($response->failed()) {
        return response()->json(['error' => 'Failed to fetch from Sloan API'], 500);
    }

    $data = $response->json();
    $clients = $data['clients'] ?? [];

    if (empty($clients)) {
        return response()->json(['error' => 'No clients found in Sloan API'], 400);
    }

    foreach ($clients as $client) {
        $firstname = trim($client['firstname'] ?? '');
        $middlename = trim($client['middlename'] ?? '');
        $lastname = trim($client['lastname'] ?? '');
        $status = strtolower($client['status'] ?? '');
        $loanDate = $client['loan_date'] ?? '';

        $itemName = trim("$firstname $middlename $lastname");

        // 🎨 Map Sloan status to Monday.com label + color
        if (in_array($status, ['payed', 'paid'])) {
            $statusData = ['label' => 'Paid', 'color' => 'green'];
        } elseif ($status === 'unpaid') {
            $statusData = ['label' => 'Unpaid', 'color' => 'red'];
        } else {
            $statusData = ['label' => 'Unknown', 'color' => 'gray'];
        }

        // ✅ Build column values
        $columnValues = [
            // Status (color + label)
            'color_mkwwv27d' => [
                'label' => $statusData['label'],
                'color' => $statusData['color'],
            ],
            // Loan date
            'date_mkwwtchh'  => $loanDate,
        ];

        $columnValuesJson = json_encode($columnValues, JSON_UNESCAPED_UNICODE);

        // Step 2: Check if item exists by name
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

        $checkResponse = Http::withHeaders([
            'Authorization' => $mondayApiKey,
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $checkQuery]);

        $existingItems = $checkResponse->json('data.items_by_column_values') ?? [];

        // Step 3: Update or Create
        if (!empty($existingItems)) {
            $itemId = $existingItems[0]['id'];

            $mutation = <<<GRAPHQL
            mutation {
              change_multiple_column_values(
                board_id: $boardId,
                item_id: $itemId,
                column_values: "$columnValuesJson"
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
                column_values: "$columnValuesJson"
              ) {
                id
                name
              }
            }
            GRAPHQL;

            $action = 'Created';
        }

        // Step 4: Send mutation
        $mutationResponse = Http::withHeaders([
            'Authorization' => $mondayApiKey,
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $mutation]);

        Log::info("Item {$action}: {$itemName}", $mutationResponse->json());
    }

    return response()->json(['success' => true, 'message' => 'Board synced successfully']);
}


}
