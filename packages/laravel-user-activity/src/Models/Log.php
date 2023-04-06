<?php namespace Haruncpi\LaravelUserActivity\Models;

use App\Models\User;
use Carbon;
use Illuminate\Database\Eloquent\Model;
use JsonException;
use Str;


class Log extends Model
{
    public $timestamps = false;
    //public $dates = ['log_date'];
    protected $appends = ['dateHumanize', 'json_data', 'json_dirty_data'];

    private mixed $userInstance = User::class;

    public function __construct()
    {
        $userInstance = config('user-activity.model.user');
        if (!empty($userInstance)) {
            $this->userInstance = $userInstance;
        }
    }

    public function getLogDateAttribute($log_date)
    {
        return $this->log_date = Carbon::parse($log_date)->format('Y-m-d h:i:s A');
    }

    public function getDateHumanizeAttribute()
    {
        return Carbon::parse($this->log_date)->diffForHumans();
    }

    /**
     * @throws JsonException
     */
    public function getJsonDataAttribute()
    {
        return json_decode($this->data, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public function getJsonDirtyDataAttribute()
    {
        if (Str::isJson($this->dirty_data)) {
            return json_decode($this->dirty_data, true, 512, JSON_THROW_ON_ERROR);
        }

        return [];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo($this->userInstance);
    }
}
