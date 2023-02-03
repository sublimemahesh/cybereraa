<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;
use JsonException;

class ActivityLogAction
{
    /**
     * @throws JsonException
     */
    public function exce($action, $previousData = [], $newData = []): void
    {
        $log_data = [
            'RESPONSIBLE USER' => auth()->user()->only(['id', 'username', 'email']),
            'PREVIOUS DATA' => $previousData,
            'NEW DATA' => $newData,
            'ACTION' => $action,
        ];
        $log_data = json_encode($log_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        Log::channel('daily')->notice('USER ACTIVITY LOG DATA: ' . $log_data);
    }
}