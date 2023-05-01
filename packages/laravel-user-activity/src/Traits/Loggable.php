<?php

namespace Haruncpi\LaravelUserActivity\Traits;

use App\Models\User;
use Arr;
use Exception;
use Log as Logger;

trait Loggable
{
    use Log;

    public static function bootLoggable()
    {
        if (config('user-activity.log_events.on_edit', false)) {
            self::updated(function ($model) {
                try {
                    if (($model instanceof User) && $model->isDirty('password')) {
                        $log_data = [
                            'RESPONSIBLE USER' => auth()->user()?->only(['id', 'username', 'email']),
                            'PREVIOUS DATA' => Arr::except($model->getRawOriginal(), $model->exclude),
                            'NEW DATA' => $model->getDirty(),
                            'ACTION' => 'users.change-password',
                        ];
                        $log_data['NEW DATA']['password'] = 'hidden';
                        $log_data = json_encode($log_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
                        Logger::channel('daily')->notice('PASSWORD CHANGE ACTIVITY | DATA: ' . $log_data);
                    }
                } catch (Exception $e) {

                }

                self::logToDb($model, 'edit');
            });
        }


        if (config('user-activity.log_events.on_delete', false)) {
            self::deleted(function ($model) {
                self::logToDb($model, 'delete');
            });
        }


        if (config('user-activity.log_events.on_create', false)) {
            self::created(function ($model) {
                self::logToDb($model, 'create');
            });
        }
    }
}
