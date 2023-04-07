<?php

namespace Haruncpi\LaravelUserActivity\Traits;

use App\Models\User;
use Arr;
use Carbon;
use DB;
use Exception;
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
        $dirtyData = Arr::except($model->toArray(), $model->exclude);
        if ($logType === 'create') {
            $originalData = $model->toArray();
        } else if (version_compare(app()->version(), '7.0.0', '>=')) {
            $originalData = Arr::except($model->getRawOriginal(), $model->exclude);
        } // getRawOriginal available from Laravel 7.x
        else {
            $originalData = Arr::except($model->getOriginal(), $model->exclude);
        }

        $tableName = $model->getTable();
        $dateTime = Carbon::now()->format('Y-m-d H:i:s');
        $userId = auth()->user()->id;

        try {
            if (($model instanceof User) && $model->isDirty('password')) {
                $originalData['password'] = 'Password changed';
                $dirtyData['password'] = 'Password changed';
            }
        } catch (Exception $e) {

        }
        
        $originalData['ip'] = request()?->ip();
        $originalData['user_agent'] = request()?->userAgent();
        $originalData = json_encode($originalData, JSON_THROW_ON_ERROR);
        $dirtyData = json_encode($dirtyData, JSON_THROW_ON_ERROR);

        DB::table(self::$logTable)->insert([
            'user_id' => $userId,
            'log_date' => $dateTime,
            'table_name' => $tableName,
            'log_type' => $logType,
            'data' => $originalData,
            'dirty_data' => $dirtyData,
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
