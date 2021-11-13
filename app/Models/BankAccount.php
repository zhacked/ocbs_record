<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function BankDetails(){
        return $this->hasOne('App\Models\arena','id', 'arenas_id');
    }
}
