<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class position extends Model
{
    use HasFactory, LogsActivity;
    protected $guarded = [];

    protected static $logAttributes = ['position'];
    protected static $logName = 'position';

}
