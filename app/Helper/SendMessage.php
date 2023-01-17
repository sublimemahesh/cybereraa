<?php

function sendSMS($to, $message): bool
{
    $data = [
        'user_id' => config('ozone-desk.user_id', null),
        'api_key' => config('ozone-desk.api_key', null),
        'sender_id' => config('ozone-desk.sender_id', null),
        'to' => $to,
        'message' => $message
    ];

    $response = Http::get(config('ozone-desk.url', null), $data);

    return $response->json()['status'] === 'success';
}