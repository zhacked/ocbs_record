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

        return Team::latest()->get();
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     

        $team =  Team::create([
            'name' => $request['name'],
        ]);

        $activity_controller = new ActivitylogsController;
        $activity_controller->arenaLogs('created',$team->name,'arena',$team->id);

        return $team;
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

     
        $activity_controller = new ActivitylogsController;
        $activity_controller->arenaLogs('updated',$request->team,'arena',$id); 

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
  
        $team = Team::findOrFail($id);
        
        $activity_controller = new ActivitylogsController;
        $activity_controller->arenaLogs('deleted',$team->team,'arena',$id); 

        $team->delete();


        
    }

    public function arena($id,$action,$request){
        $updateteam  = Team::findOrFail($id);
        $arenateam =  arena::where('team',$updateteam->name)->get();
      
        foreach ($arenateam as $data){
            $arena = arena::where('team',$data->team)->$action([
                'team' => $request,
            ]);

            $activity_controller = new ActivitylogsController;
            $activity_controller->arenaLogs($action,$arena->team,'arena',$id); 
    
        }
    }

    
}
