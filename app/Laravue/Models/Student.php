<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory, LogsActivity;
    protected $guard_name = 'api';
    protected $fillable = ['first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address', 'website'];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    
    // Activity Logs begins
    protected static $logAttributes = ['first_name', 'last_name', 'business_name', 'email', 'contact_person', 'contact_no', 'address', 'website'];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Student has been {$eventName}";
    }
    // Activity Logs ends
}
