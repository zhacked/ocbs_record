<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class import extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function arenaDetails(){
        return $this->hasOne('App\Models\arena','id', 'arena_id');
    }

    public function BankDetails(){
        return $this->hasMany('App\Models\BankAccount','arenas_id', 'id');
    }
}
