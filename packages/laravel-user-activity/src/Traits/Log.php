<?php

namespace Haruncpi\LaravelUserActivity\Traits;

use Arr;
use DB;
use JsonException;
use Log as Logger;

trait Log
{

    static protected string $logTable = 'logs';

    /**
     * @throws JsonException
     */
    public static function logToDb($model, $logType): void
    {
        if (!auth()->check() || $model->excludeLogging || !config('user-activity.activated', true)) {
            return;
        }
        if ($logType === 'create') {
            $originalData = json_encode($model, JSON_THROW_ON_ERROR);
        } else if (version_compare(app()->version(), '7.0.0', '>=')) {
            $originalData = json_encode(Arr::except($model->getRawOriginal(), $model->exclude), JSON_THROW_ON_ERROR);
        } // getRawOriginal available from Laravel 7.x
        else {
            $originalData = json_encode(Arr::except($model->getOriginal(), $model->exclude), JSON_THROW_ON_ERROR);
        }

        $tableName = $model->getTable();
        $dateTime = date('Y-m-d H:i:s');
        $userId = auth()->user()->id;

        DB::table(self::$logTable)->insert([
            'user_id' => $userId,
            'log_date' => $dateTime,
            'table_name' => $tableName,
            'log_type' => $logType,
            'data' => $originalData
        ]);

        if (!auth()->user()->hasRole('user')) {
            $log_data = [
                'RESPONSIBLE USER' => auth()->user()->only(['id', 'username', 'email']),
                'PREVIOUS DATA' => Arr::except($model->getRawOriginal(), $model->exclude),
                'NEW DATA' => $model->getDirty(),
                'ACTION' => $tableName . '-' . $logType,
            ];
            $log_data = json_encode($log_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            Logger::channel('daily')->notice('USER ACTIVITY LOG FROM ' . $tableName . ' | DATA: ' . $log_data);
        }
    }
}