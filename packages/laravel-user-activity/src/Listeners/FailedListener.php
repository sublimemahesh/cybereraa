<?php

namespace Haruncpi\LaravelUserActivity\Listeners;

use App\Models\User;
use Carbon;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FailedListener
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Failed $event)
    {
        $user = User::where('username', $event->credentials['username'])->first();

        if (!$user) {
            return;
        }

        $data = [
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'ip' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'credentials' => $event->credentials,
            'attempt_user' => $event->user?->only(['id', 'username', 'email', 'phone']),
        ];

        DB::table('logs')->insert([
            'user_id' => $user->id,
            'log_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'table_name' => '',
            'log_type' => 'lockout',
            'data' => json_encode($data)
        ]);
    }
}
