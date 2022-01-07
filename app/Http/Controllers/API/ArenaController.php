<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\arena;
use App\Models\Email;
use App\Models\BankAccount;
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
         return arena::with('BankDetails')->get();
    }

    // public function arenaSelectedBank($bankId)
    // {
    //      return BankAccount::where('bank_id',$bankId)->get();
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
            'contact_number' => 'required|numeric',
         
        ]);

        $arena =  arena::create([
            'arena' => $request['arena'],
            'address' => $request['address'],
            'operator' => $request['operator'],
            'contact_number' => $request['contact_number'],
        
        ]);

        foreach ($request['email'] as $email){
             Email::updateOrCreate([
                'arena_id' => $arena->id,
                'email' => $email
            ]);
        }
        return $arena;
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
    public function getEmilByid($id)
    {
        return Email::where('arena_id',$id)->get();
    }

    public function deleteEmail($id){
        $email = Email::findOrFail($id);
       
        $email->delete();
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
            'contact_number' => 'required|numeric',
        ]);

        $arena = arena::with('BankDetails')->where('id',$id)->update([
            'arena' => $request['arena'],
            'address' => $request['address'],
            'operator' => $request['operator'],
            'contact_number' => $request['contact_number'],

        ]);
   
            foreach ($request['email'] as $email){
                    if(!is_array($email)){
                        $data = Email::Create([
                            'arena_id' => $request['id'],
                            'email' => $email
                        ]);
                     }
            }
  
          
       
        return ['message' => 'Updated the areana details'];
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
        $email = Email::where('arena_name',$arena->arena);
       
        if($email){
            $email->delete();
        }
        $arena->delete();

        return ['message' => 'User Deleted'];
    }
}
