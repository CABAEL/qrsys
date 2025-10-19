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

    $clients = $response->json()['clients'] ?? [];
    if (empty($clients)) {
        return response()->json(['error' => 'No clients found in Sloan API'], 400);
    }

    // Step 2: Get Monday.com groups
    $groupsQuery = <<<GRAPHQL
    query {
        boards(ids: $boardId) {
            groups {
                id
                title
            }
        }
    }
    GRAPHQL;

    $groupsRes = Http::withHeaders([
        'Authorization' => $mondayApiKey,
        'Content-Type' => 'application/json',
    ])->post($mondayApiUrl, ['query' => $groupsQuery]);

    $groupsData = $groupsRes->json()['data']['boards'][0]['groups'] ?? [];
    $groupMap = [];
    foreach ($groupsData as $group) {
        $groupMap[strtolower($group['title'])] = $group['id'];
    }

    // Map Sloan status to Monday.com status labels and group names
    $statusMap = [
        'payed'  => ['label' => 'Paid', 'group' => 'payed'],
        'unpaid' => ['label' => 'Unpayed', 'group' => 'unpayed'],
    ];

    // Step 3: Get existing items
    $itemsQuery = <<<GRAPHQL
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
    ])->post($mondayApiUrl, ['query' => $itemsQuery]);

    $existingItems = $existingItemsRes->json()['data']['boards'][0]['items'] ?? [];
    $existingMap = [];
    foreach ($existingItems as $item) {
        $existingMap[$item['name']] = $item['id'];
    }

    // Step 4: Upsert items
    foreach ($clients as $client) {
        $itemName = $client['client_name'];
        $statusKey = strtolower($client['status']);
        $statusLabel = $statusMap[$statusKey]['label'] ?? 'Unpayed';
        $groupTitle = $statusMap[$statusKey]['group'] ?? 'default';
        $groupId = $groupMap[$groupTitle] ?? $groupMap['default'] ?? '';

        if (!$groupId) {
            Log::error("No valid group found for {$itemName}, status: {$statusKey}");
            continue;
        }

        $columnValues = [
            'color_mkwwdrf8' => ['label' => $statusLabel], // Status
            'date_mkwwtchh'  => $client['loan_date'] ?? '',
            'text_mkwwnfvf'  => $client['loan_amount'] ?? ''
        ];

        $columnValuesJson = json_encode($columnValues, JSON_UNESCAPED_SLASHES);

        if (isset($existingMap[$itemName])) {
            // Update existing item
            $itemId = $existingMap[$itemName];
            $mutation = <<<GRAPHQL
            mutation {
                change_column_values(item_id: $itemId, board_id: $boardId, column_values: "$columnValuesJson") {
                    id
                    name
                }
            }
            GRAPHQL;
        } else {
            // Create new item
            $mutation = <<<GRAPHQL
            mutation {
                create_item(board_id: $boardId, group_id: "$groupId", item_name: "$itemName", column_values: "$columnValuesJson") {
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

        $resJson = $res->json();

        if (isset($resJson['errors'])) {
            Log::error("Monday.com mutation failed for {$itemName}", $resJson['errors']);
        } else {
            Log::info("Upserted Item: {$itemName}", $resJson['data']);
        }
    }

    return response()->json(['success' => true, 'message' => 'Board synced successfully']);
}




}
