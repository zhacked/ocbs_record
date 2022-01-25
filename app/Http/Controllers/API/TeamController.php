<?php

namespace App\Http\Controllers\API;

use view;
use App\Models\Team;
use App\Models\arena;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class TeamController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:api');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Team::with(['userDetails.positionDetails','arenaDetails'])->latest()->get();
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     

        return Team::create([
            'name' => strtolower($request['name']),
            
        ]);
    }


   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->arena($id,'update',$request->team);
  
        return Team::findOrFail($id)->update([
            'name' => $request->team,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->arena($id,'delete',null);
        return Team::findOrFail($id)->delete();
    }

    public function arena($id,$action,$request){
        $updateteam  = Team::findOrFail($id);
        $arenateam =  arena::where('team',$updateteam->name)->get();
      
        foreach ($arenateam as $data){
            arena::where('team',$data->team)->$action([
                'team' => $request,
            ]);

        }
    }

    
}
