<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\arena;
use App\Models\Email;
use App\Models\Contact;
use App\Models\BankAccount;
use App\Models\Activitylogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
   
    public function __construct()
    {
        $this->middleware('auth:api');

    }


    public function index()
    {
         return arena::with([
            'ContactDetails',
            'BankDetails.BankActivity' => function ($q){
               return $q->where('description','updated')->latest();
            } 
         ])->get();
    }

    public function getArenaTeam($team){
      
        $arenaTeam = arena::where('team', strtolower($team))->get();
        return $arenaTeam;
        
    }

    public function getArenaNoTeam(){
      
        $arenaTeam = arena::whereNull('team')->get();
        return $arenaTeam;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     
        $this->validate($request,[
            'arena' => 'required|string',
            'address' => 'required|string|max:191',
            'operator' => 'required|string',
        ]);

        $arena =  arena::create([
            'area_code' => $request['area_code'],
            'arena' => $request['arena'],
            'address' => $request['address'],
            'operator' => $request['operator'],
            'contact_number' => 'xxxxx',

        ]);




        // foreach ($request['email'] as $email){
             Email::updateOrCreate([
                'area_code' => $arena->area_code,
                'email' => $email
            ]);
        // }

        // foreach ($request['contact_number'] as $contact){
            Contact::updateOrCreate([
               'area_code' => $arena->area_code,
               'contact_number' => $contact
           ]);
    //    }
        $activity_controller = new ActivitylogsController;
        $activity_controller->arenaLogs('created',$arena->arena,'arena',$arena->id);

        return $arena;
    }

    public function importArena(Request $request){
  
    $contactImport = arena::upsert($request['arenaList'], ['area_code']);
    $activity_controller = new ActivitylogsController;
    $activity_controller->arenaLogs('imported',$request['Uploadname'],'arena',1);
    return  $contactImport;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  arena::findOrFail($id);;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEmails($areaCode)
    {

       $email =  Email::where('area_code',$areaCode)->get();

       return $email;
    }

    public function getContacts($areaCode)
    {

       $contact =  Contact::where('area_code',$areaCode)->get();

       return $contact;
    }

    public function deleteEmail($id){
        $email = Email::findOrFail($id);
        $this->Arenaactivity('deleted',$email->email,'arena',$id);
        $email->delete();
     
        
    }


    public function deleteContact($id){
        $contact = Contact::findOrFail($id);

        $contact->delete();
    }


    public function updateBankSelection(Request $request, $id) {

        $arena = arena::with('BankDetails')->where('id',$id);
        $arenaBankSelected = $arena->update([
            'bank_id' => $request['bank_id'],
        ]);

        return $arena->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $arenas = arena::with('BankDetails')->findOrFail($id);


        $this->validate($request,[
            'arena' => 'required|string',
            'address' => 'required|string|max:191',
            'operator' => 'required|string',

        ]);

        $arena = arena::with('BankDetails')->where('id',$id)->update([
            'arena' => $request['arena'],
            'address' => $request['address'],
            'operator' => $request['operator'],
            'contact_number' => 'xxxxxxx',

        ]);

            // foreach ($request['email'] as $email){
                    // if(!is_array($email)){
                    //    Email::updateOrCreate([
                    //         'area_code' => $request['area_code'],
                    //         'email' => $request['email']
                    //     ]);

                        Email::where('area_code', $request['area_code'])->update([
                            'email' => $request['email']
                        ]);
                    //  }
            // }

            // foreach ($request['contact_number'] as $contact){
                // if(!is_array($contact)){
                //    Contact::updateOrCreate([
                //         'area_code' => $request['area_code'],
                //         'contact_number' => $request['contact_number']
                //     ]);

                Contact::where('area_code', $request['area_code'])->update([
                        'contact_number' => $request['contact_number']
                    ]);


                //  }
        // }
     
        $this->Arenaactivity('updated',$arenas->arena,'arena',$arenas->id);
        return ['message' => 'Updated the arena details'];
    }

    public function updateArenaTeam(Request $request, $code) {
        $arena = arena::where('area_code', $code)->firstOrFail();
      
        $team = $request['team'] ? strtolower($request['team']) : null;
        $arena->update([
            'team' => $team ,
        ]);

        return $arena;
    }

    public function updateSelectedArenaToTeam(Request $request,$team) {
      

        foreach($request->all() as $data){
            $arena = arena::where('area_code', $data['area_code']);

            $arena->update([
                'team' => $team
            ]);
        };


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $arena = arena::findOrFail($id);
        // delete the user
        $email = Email::where('area_code',$arena->area_code);

        if($email){
            $email->delete();
        }

        $this->Arenaactivity('deleted',$arena->arena,'arena',$arena->id);
        $arena->delete();
      
        return ['message' => 'User Deleted'];
    }

    public function Arenaactivity($action,$description,$model,$id){
        $activity_controller = new ActivitylogsController;
        $activity_controller->arenaLogs($action,$description,$model,$id); 
    }

   
}
