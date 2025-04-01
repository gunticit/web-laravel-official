<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/slack/events', function (Request $request) {
    $data = $request->all();

    if (isset($data['challenge'])) {
        return response($data['challenge']);
    }

    Log::info('Slack Event:', $data);

    return response()->json(['status' => 'OK']);
});