<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitylogs extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function User(){
        return $this->hasOne('App\Models\User','id', 'causer_id');
    }

}
