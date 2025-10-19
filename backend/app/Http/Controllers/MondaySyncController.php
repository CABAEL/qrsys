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

    $response = Http::get($sloanApiUrl);
    if ($response->failed()) return response()->json(['error' => 'Failed to fetch from Sloan API'], 500);

    $clients = $response->json()['clients'] ?? [];
    if (empty($clients)) return response()->json(['error' => 'No clients found in Sloan API'], 400);

    // Map status to group
    $groupMap = [
        'payed'  => 'Payed',
        'unpaid' => 'Unpayed',
    ];

    // Get existing items
    $query = <<<GRAPHQL
    query {
        boards(ids: $boardId) {
            items {
                id
                name
                group {
                    id
                }
            }
        }
    }
    GRAPHQL;

    $existingItemsRes = Http::withHeaders([
        'Authorization' => $mondayApiKey,
        'Content-Type' => 'application/json',
    ])->post($mondayApiUrl, ['query' => $query]);

    $existingItems = $existingItemsRes->json()['data']['boards'][0]['items'] ?? [];
    $existingMap = [];
    foreach ($existingItems as $item) {
        $existingMap[$item['name']] = $item;
    }

    foreach ($clients as $client) {
        $itemName = $client['client_name'];
        $status = strtolower($client['status']);
        $groupId = $groupMap[$status] ?? 'CLIENT DATA';

        $columnValues = [
            'color_mkwwdrf8' => ['label' => ucfirst($status)], // make sure label matches exactly
            'date_mkwwtchh'  => $client['loan_date'] ?? '',
            'text_mkwwnfvf'  => $client['loan_amount'] ?? ''
        ];

        $columnValuesEscaped = addslashes(json_encode($columnValues));

        if (isset($existingMap[$itemName])) {
            // Update existing item
            $itemId = $existingMap[$itemName]['id'];
            $mutation = <<<GRAPHQL
            mutation {
                change_column_values(item_id: $itemId, board_id: $boardId, column_values: "$columnValuesEscaped") {
                    id
                    name
                }
            }
            GRAPHQL;
        } else {
            // Create new item in correct group
            $mutation = <<<GRAPHQL
            mutation {
                create_item(board_id: $boardId, group_id: "$groupId", item_name: "$itemName", column_values: "$columnValuesEscaped") {
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
