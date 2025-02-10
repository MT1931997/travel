<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    protected function logActivity($event)
    {
        $user = Auth::user();
        $logData = [
            'event' => $event,
            'model' => get_class($this),
            'model_id' => $this->id,
            'attributes' => $this->getAttributes(),
            'user_id' => $user ? $user->id : null,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('user_activity')->info('User activity log', $logData);
    }
}
