<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class employee extends Model
{
    use HasFactory,LogsActivity;
    protected $guarded = [];

    protected static $logAttributes = ['name','email','position','address','contact','group','assign'];
    protected static $logName = 'employee';
}
