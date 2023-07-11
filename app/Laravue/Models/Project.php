<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'student_id', 'code', 'location', 'location', 'description', 'start_date', 'end_date', 'status'];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    // Activity Logs begins
    protected static $logAttributes = ['name', 'student_id', 'code', 'location', 'location', 'description', 'start_date', 'end_date', 'status'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Project has been {$eventName}";
    }
    // Activity Logs ends
}
