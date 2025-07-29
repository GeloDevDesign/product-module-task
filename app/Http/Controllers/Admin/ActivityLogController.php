<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Audit Logs';
        $users = User::all()->whereNotNull('last_login');
        $usernames = $users->pluck('name')->toArray();

        $query = Activity::latest()->whereNotNull('causer_id');

        if ($request->exists('s')) {
            $query = $query->when($request->get('s') ?? false,function($query,$search){
                $query->where('description', 'like',  '%'.$search.'%');
            });
        }

        if ($request->exists('user')) {
            $query = $query->when($request->get('user') ?? false,function($query,$user){
                $query->where('causer_id', '=', $user);
            });
        }

        if ($request->exists('date')) {
            $query = $query->when($request->get('date') ?? false, function($query,$dates){

                $dateRange = $this->sanitizeDateRange($dates);
                $fromDate = optional($dateRange)->fromDate;
                $toDate = optional($dateRange)->toDate;

                if ($fromDate && $toDate) {
                    $query->whereDate('created_at', '>=', $fromDate)
                      ->whereDate('created_at', '<=', $toDate);
                }
            });
        }

        $query = $query->where('properties','not like','%last_login%');

        if ($request->filled('per_page')) {
            if ($request->per_page != 'all') {
                $logs = $query->paginate($request->per_page);
            } else {
                $logs = $query->get();
            }
        } else {
            $logs = $query->paginate(50);
        }

        $activities = $this->sanitizeLogs($logs);

        $filters = [
            's' => $request->s, 
            'user' => $request->user, 
            'date' => $request->date, 
            'page' => $request->page, 
            'per_page' => $request->per_page, 
        ];

        return view('admin.activity_logs.index', compact('activities', 'title', 'users', 'filters'));
    }

    public function sanitizeLogs($logs)
   {
       $updatesLogs = [];

       $logs->map(function($actLog) {
        //    $props = $actLog->properties;
           $props = $actLog->changes;

           if ( $props && $props->isNotEmpty() ) {
               $updates = $props['attributes'];
               $old = $props['old'] ?? null;
               $action = $actLog->description;
   
               $messages = [];

                foreach ($updates as $key => $update) {
                    $message = $action;    
                    $excludedKeys = ['id', 'created_at', 'updated_at'];

                    if ($update || is_bool($update)) {
                        if (!in_array($key, $excludedKeys)) {
                            if ($old && $update != $old[$key]) {
                                $hasId = Str::contains($key, '_id');
        
                                $oldValue = $old[$key];
                                $updateValue = $update;
                                $targetProp = $key;
        
                                $invalidKeys = ['role'];
        
                                if ($hasId) {
                                    if( Str::contains($key, 'state_id') ){
        
                                        $rawRelation = str_replace('_id', '', $key);
                                        
                                        $relationNamespace = "\\App\\Models\\UsState";
        
                                    }
                                    else if(Str::contains($key, 'country_id')){
                                        
                                        $rawRelation = str_replace('_id', '', $key);
                                            
                                        $relationNamespace = "\\App\\Models\\Country";
                                    }
                                    else{
                                        $rawRelation = str_replace('_id', '', $key);
                                        $relationNamespace = "\\App\\Models\\Country";
        
                                    }
                                    
                                    $currRelation = ucwords(str_replace('_', ' ', $rawRelation));
                                    $relationName = str_replace(' ', ' ', $currRelation);
                                    $oldInstance = $relationNamespace::find($old[$key]);
                                    $newInstance = $relationNamespace::find($update);
        
                                    $targetProp = $relationName;
                                    $oldValue = optional($oldInstance)->name;
                                    $updateValue = optional($newInstance)->name;
                                    
                                }
                                
                                $formattedProp = ucwords(str_replace('_', ' ', $targetProp));
                                $booleanProps = ['active', 'current_host', 'maintenance_mode' ];
        
                                if (in_array($targetProp, $booleanProps)) {
                                    $oldValue = $oldValue && $oldValue == 1 ? 'True' : 'False';
                                    $updateValue = $updateValue && $updateValue == 1 ? 'True' : 'False';
        
                                    $formattedProp = $formattedProp .' Status';
                                    $message = "{$formattedProp} from {$oldValue} to {$updateValue}";

                                } else if ( $updateValue && is_string($updateValue)) {
                                        
                                    if ($oldValue && is_string($oldValue) && $targetProp != 'password') {
                                        $updateValue = $updateValue ?? 'Empty';
                                        
                                        $explodeOld = explode('/', $oldValue);
                                        $sanitizedOld = $explodeOld && count($explodeOld) > 1 ? $explodeOld[count($explodeOld) - 1] : $oldValue;
    
                                        $explodeUpdate = explode('/', $updateValue);
                                        $sanitizedUpdate = $explodeUpdate && count($explodeUpdate) > 1 ? $explodeUpdate[count($explodeUpdate) - 1] : $updateValue;
    
                                        $message = "{$formattedProp} from {$sanitizedOld} to {$sanitizedUpdate}";
                                    }
                                    else if( Str::contains($key, 'social_media_url') || $targetProp == 'password' ){
                                        $message = "{$formattedProp}";
                                    }
                                    else {
                                        $updateValue = $updateValue ?? 'Empty';

                                        $sanitizedUpdate = '';
    
                                        if (Str::contains($updateValue, '/')) {
                                            $explodeUpdate = explode('/', $updateValue);
                                            $sanitizedUpdate = $explodeUpdate && count($explodeUpdate) > 1 ? $explodeUpdate[count($explodeUpdate) - 1] : $updateValue;
                                            $message = "{$formattedProp} to {$sanitizedUpdate}";
                                        }
    
                                        if (Str::contains($updateValue, '\\')) {
                                            $explodeUpdate = explode('\\', $updateValue);
                                            $sanitizedUpdate = $explodeUpdate && count($explodeUpdate) > 1 ? $explodeUpdate[count($explodeUpdate) - 1] : $updateValue;
                                            $message = "{$formattedProp} to {$sanitizedUpdate}";
                                        }
                                        
                                        // $message = "{$formattedProp} to {$sanitizedUpdate}";
                                    }
                                } else if ($updateValue && is_array($updateValue)) {
                                    if ($key == 'notification_emails') {
                                        $sanitizedOld = implode(', ', $oldValue);
                                        $sanitizedUpdate = implode(', ', $updateValue);
                                        $message = "{$formattedProp} from {$sanitizedOld} to {$sanitizedUpdate}";
                                    }
                                }
        
                                //    if( str_word_count($message) < 10 ){
                                    $messages[] = $message;
                                //    }
                                /* else{
                                    $messages[] = "{$formattedProp}";
                                } */
        
                            }
                        }
                    } else if (!$update && $key == 'profile_picture') {
                        $messages[] = 'Removed Profile Photo';
                    }
    
                }

               $actLog->messages = $messages;
           }

           return $actLog;
       });

       return $logs;
   }
}
