<?php

namespace Haruncpi\LaravelUserActivity\Listeners;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\DB;
use Log;

class LockoutListener
{

    private mixed $userInstance = User::class;

    public function __construct()
    {
        $userInstance = config('user-activity.model.user');
        if (!empty($userInstance)) {
            $this->userInstance = $userInstance;
        }
    }


    public function handle(Lockout $event)
    {
        Log::info('User locked out: ' . $event->request->input('username'));

        if (!config('user-activity.log_events.on_lockout', true)
            || !config('user-activity.activated', true)) {
            return;
        }

        $user = $this->userInstance::where('username', $event->request->input('username'))->first();

        if (!$user) {
            return;
        }

        $data = [
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'ip' => $event->request->ip(),
            'user_agent' => $event->request->userAgent()
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
