<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Activitylogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivitylogsController extends Controller
{
    public function logsIndex()
    {
        return Activitylogs::where('subject_type','arena')->orWhere('subject_type','bank')->latest()->get();
    }
    public function arenaLogs($description,$properties,$model){
        $activity=  Activitylogs::insert([
             'log_name' => Auth::user()->name,
             'description'=> $description,
             'subject_type' => $model,
             'subject_id'=>Auth::user()->id,
             'causer_type' =>Auth::user()->type,
             'properties'=> $properties,
             'causer_id' =>Auth::user()->id,
             'created_at'=> Carbon::now()->toDateTimeString()
         ]);
 
         return $activity;
     }

    
}
