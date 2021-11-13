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
}
