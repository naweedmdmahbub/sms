<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'email', 'number', 'department_id', 'guardian_number'];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
    // Activity Logs begins
    protected static $logAttributes = ['name', 'email', 'number', 'department_id', 'guardian_number'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Student has been {$eventName}";
    }
    // Activity Logs ends
}
