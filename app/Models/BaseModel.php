<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaseModel extends Model
{
    use LogsActivity;

    public function __construct()
    {

    }
    

    public function activityLogs()
    {
        $instance = $this;
        $activities = Activity::forSubject($instance)->orWhere(function($query) use ($instance) {
            $query
                ->where('subject_type', ($this)->getMorphClass())
                ->where('subject_id', $instance->id);
        })->get();

        return $activities;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
