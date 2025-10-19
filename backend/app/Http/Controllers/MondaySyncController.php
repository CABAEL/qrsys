<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MondaySyncController extends Controller
{
    /**
     * Sync Sloan client data to Monday.com board.
     */
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

        $data = $response->json();
        $clients = $data['clients'] ?? [];

        if (empty($clients)) {
            return response()->json(['error' => 'No clients found in Sloan API'], 400);
        }

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

            $res = Http::withHeaders([
                'Authorization' => $mondayApiKey,
                'Content-Type' => 'application/json',
            ])->post($mondayApiUrl, ['query' => $mutation]);

            Log::info("Created column: {$columnTitle}", $res->json());
        }

        foreach ($clients as $client) {
            $itemName = "{$client['firstname']} {$client['lastname']}";

            $columnValues = [
                'firstname'  => $client['firstname'],
                'middlename' => $client['middlename'],
                'lastname'   => $client['lastname'],
                'status'     => $client['status'],
                'loan_date'  => $client['loan_date'],
            ];

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

            $res = Http::withHeaders([
                'Authorization' => $mondayApiKey,
                'Content-Type' => 'application/json',
            ])->post($mondayApiUrl, ['query' => $mutation]);

            Log::info("Created item: {$itemName}", $res->json());
        }

        return response()->json(['success' => true, 'message' => 'Board synced successfully']);
    }
}
