<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class arena extends Model
{
    use HasFactory, LogsActivity;
    protected $guarded = [];

    
 


    public function BankDetails(){
        return $this->hasMany('App\Models\BankAccount','area_code', 'area_code');
    }

    public function ArenaBankDetails(){
        return $this->hasOne('App\Models\BankAccount','id', 'bank_id');
    }
    
    public function EmailDetails(){
        return $this->hasMany('App\Models\Email','area_code', 'area_code');
    } 

    public function ContactDetails(){
        return $this->hasMany('App\Models\Contact','area_code', 'area_code');
    } 
    // protected static $logAttributes = ['arena','BankDetails.bank_name','BankDetails.bank_number','EmailDetails.email']; // ERROR
    
    // protected static $logName = 'arena';
    
}
