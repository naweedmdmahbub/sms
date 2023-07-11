<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['name', 'email', 'number', 'total_credit', 'department_head'];

    public function students(){
        return $this->hasMany(Student::class);
    }

    // Activity Logs
    protected static $logAttributes = ['name', 'email', 'number', 'total_credit', 'department_head'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Department has been {$eventName}";
    }
}
