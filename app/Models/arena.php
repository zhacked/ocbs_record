<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arena extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function BankDetails(){
        return $this->hasMany('App\Models\BankAccount','arenas_id', 'id');
    }

    public function ArenaBankDetails(){
        return $this->hasOne('App\Models\BankAccount','id', 'bank_id');
    }
    
    public function EmailDetails(){
        return $this->hasMany('App\Models\Email','arena_name', 'arena');
    } 
}
