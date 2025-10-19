<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MondaySyncController extends Controller
{
public function sync()
{
    $sloanResponse = Http::get('https://abbynavarro.github.io/Abby.github.io/api/');
    $sloanData = $sloanResponse->json();

    $clients = $sloanData['clients'] ?? [];

    foreach ($clients as $client) {
        Http::withHeaders([
            'Authorization' => env('MONDAY_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.monday.com/v2', [
            'query' => '
                mutation ($boardId: Int!, $itemName: String!, $columnValues: JSON!) {
                    create_item (board_id: $boardId, item_name: $itemName, column_values: $columnValues) {
                        id
                    }
                }
            ',
            'variables' => [
                'boardId' => env('MONDAY_BOARD_ID'), // your Monday board ID
                'itemName' => $client['firstname'] . ' ' . $client['lastname'],
                'columnValues' => json_encode([
                    'text' => $client['firstname'], // column ID for Firstname
                    'text1' => $client['middlename'],
                    'text2' => $client['lastname'],
                    'status' => ['label' => ucfirst($client['status'])],
                    'date' => ['date' => $client['loan_date']],
                ]),
            ],
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Board synced successfully']);
}

}
