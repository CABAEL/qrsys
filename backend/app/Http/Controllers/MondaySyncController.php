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

        $res = Http::withHeaders([
            'Authorization' => "Bearer {$mondayApiKey}",
            'Content-Type' => 'application/json',
        ])->post($mondayApiUrl, ['query' => $mutation]);

        Log::info("Created Item: {$itemName}", $res->json());
    }

    return response()->json(['success' => true, 'message' => 'All items created successfully']);
}


}
