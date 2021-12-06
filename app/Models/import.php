<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Facades\Excel;class import extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function arenaDetails(){
        return $this->hasOne('App\Models\arena','arena', 'arena_name');
    }

    public function BankDetails(){
        return $this->hasMany('App\Models\BankAccount','arenas_id', 'id');
    }
    
    public function getImport() {
        $records = DB::table('imports')->select('id','arena_name','for_total')->get()->toArray();
        return $records;
    }
}