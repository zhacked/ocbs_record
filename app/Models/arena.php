<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class arena extends Model
{
    use HasFactory;
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

 

    public function UserTeam(){
        return $this->hasOne('App\Models\Team','name','team');
        // return $this->hasManyThrough('App\Models\User', 'App\Models\Team','id','team_id', 'team','name');
    }

    public function ContactDetails(){
        return $this->hasMany('App\Models\Contact','area_code', 'area_code');
    } 

    public function BankActivity(){
        return $this->hasMany('App\Models\Activitylogs','subject_id', 'id');
    }


    
}
