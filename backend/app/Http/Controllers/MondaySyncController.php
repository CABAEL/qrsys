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
    if ($response->failed()) {
        return response()->json(['error' => 'Failed to fetch from Sloan API'], 500);
    }

    $clients = $response->json('clients', []);
    if (empty($clients)) {
        return response()->json(['error' => 'No clients found in Sloan API'], 400);
    }

    foreach ($clients as $client) {
        $itemName = addslashes(trim($client['client_name'] ?? 'Unnamed Client'));

        $columnValues = [
            'color_mkwwm9wt' => [ 'label' => $client['status'] ?? ''],
            'text_mkwwnfvf' => (string) ($client['loan_amount'] ?? ''),
            'date_mkwwtchh' => $client['loan_date'] ?? '',
        ];

        // Escape JSON string for GraphQL
        $columnValuesJson = addslashes(json_encode($columnValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

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

        $created_res = Http::withHeaders([
            'Authorization' => "Bearer {$mondayApiKey}",
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $mutation]);

        Log::info("Created Item: {$itemName}", $created_res->json());




        //add move item to group logic here
        $createdItem = $created_res->json('data.create_item');

        // Check if creation was successful
        if (!$createdItem || !isset($createdItem['id'])) {
            Log::error("Failed to create item: {$itemName}", $created_res->json());
            continue; // skip moving if creation failed
        }

        // 2️⃣ Move the item to the correct group based on status
        $status = strtolower($client['status'] ?? '');

        if ($status === 'paid') {
            $groupId = 'group_mkww75yv';
        } elseif ($status === 'unpaid') {
            $groupId = 'group_mkww9keb';
        } else {
            Log::warning("Status not recognized for item: {$itemName} ({$status})");
            continue; // skip if status is not recognized
        }

        $moveMutation = <<<GRAPHQL
        mutation {
            move_item_to_group(item_id: {$createdItem['id']}, group_id: "{$groupId}") {
                id
            }
        }
        GRAPHQL;

        $moveRes = Http::withHeaders([
            'Authorization' => "Bearer {$mondayApiKey}",
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $moveMutation]);

        Log::info("Moved Item: {$itemName} to group {$groupId}", $moveRes->json());




    }

    return response()->json(['success' => true, 'message' => 'All items created successfully']);
}


}
