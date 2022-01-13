<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory,LogsActivity;
    protected $guarded = [];

    public function arenaDetails(){
        return $this->hasOne('App\Models\arena','area_code', 'area_code');
    }

    protected static $logAttributes = ['account_name','bank_name','bank_number'];
    protected static $logName = 'BankAccount';

}   
