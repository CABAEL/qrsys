<?php

use Illuminate\Support\Facades\Request;

function responseBuilder($status = null, $message = null, $error = null, $data = null) {
    $data_arr = [
        'status' => $status,
        'message' => $message,
        'data' => $data,
        'errors' => $error
    ];

    return response()->json($data_arr);
}

function base_url($append) {
    $urlSegments = explode('/', Request::path());
    $userLevelDir = $urlSegments[0];

    $baseUrl = Request::getSchemeAndHttpHost();

    if ($userLevelDir === '') {
        return $baseUrl . '/' . $append;
    } else {
        return $baseUrl . '/' . $userLevelDir . '/' . $append;
    }
}

function url_host($append) {
    $baseUrl = Request::getSchemeAndHttpHost() . '/';

    return $baseUrl . $append;
}
