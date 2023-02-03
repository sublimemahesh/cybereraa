<?php

namespace Haruncpi\LaravelUserActivity\Traits;

trait Loggable
{
    use Log;

    public static function bootLoggable()
    {
        if (config('user-activity.log_events.on_edit', false)) {
            self::updated(function ($model) {
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
