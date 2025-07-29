<?php

namespace App\Models;

use App\Models\BaseModel;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralSetting extends BaseModel
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'notification_emails',
        'maintenance_mode',
        'terms_and_conditions',
        'dashboard_text'
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'notification_emails' => 'array'
    ];

    // activity logs config
    protected static $submitEmptyLogs = false;
    protected static $logOnlyDirty = true;

    protected static $logFillable = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = ucfirst($eventName).' General Settings';
    }
}
