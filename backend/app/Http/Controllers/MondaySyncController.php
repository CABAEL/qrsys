<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MondaySyncController extends Controller
{
    /**
     * Sync Sloan API data structure to Monday.com board.
     */
    public function sync()
    {
        $sloanApiUrl = 'https://abbynavarro.github.io/Abby.github.io/api/';
        $mondayApiUrl = 'https://api.monday.com/v2';
        $mondayApiKey = env('MONDAY_API_KEY');
        $boardId = env('MONDAY_BOARD_ID');

        // 1️⃣ Get data structure from Sloan API
        $response = Http::get($sloanApiUrl);
        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch from Sloan API'], 500);
        }

        $data = $response->json();
        $clients = $data['clients'] ?? [];

        if (empty($clients)) {
            return response()->json(['error' => 'No clients found in Sloan API'], 400);
        }

        // 2️⃣ Use first client to generate Monday.com columns
        $firstClient = $clients[0];
        foreach ($firstClient as $field => $value) {
            $columnTitle = ucfirst(str_replace('_', ' ', $field));

            $mutation = <<<GRAPHQL
            mutation {
                create_column (board_id: $boardId, title: "$columnTitle", column_type: text) {
                    id
                    title
                }
            }
            GRAPHQL;

            Http::withHeaders([
                'Authorization' => $mondayApiKey,
                'Content-Type' => 'application/json',
            ])->post($mondayApiUrl, ['query' => $mutation]);
        }

        // 3️⃣ Add Sloan clients as items (rows)
        foreach ($clients as $client) {
            $itemName = "{$client['firstname']} {$client['lastname']}";

            // Prepare column values
            $columnValues = [
                'firstname' => $client['firstname'],
                'middlename' => $client['middlename'],
                'lastname' => $client['lastname'],
                'status' => $client['status'],
                'loan_date' => $client['loan_date'],
            ];

            $columnValuesJson = json_encode($columnValues);

            $mutation = <<<GRAPHQL
            mutation {
                create_item (
                    board_id: $boardId,
                    item_name: "$itemName",
                    column_values: "$columnValuesJson"
                ) {
                    id
                    name
                }
            }
            GRAPHQL;

            Http::withHeaders([
                'Authorization' => $mondayApiKey,
                'Content-Type' => 'application/json',
            ])->post($mondayApiUrl, ['query' => $mutation]);
        }

        return response()->json(['success' => true, 'message' => 'Board synced successfully']);
    }
}
