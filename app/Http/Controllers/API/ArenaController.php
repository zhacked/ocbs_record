<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\arena;
use App\Models\Email;
use App\Models\Contact;
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
         return arena::with(['BankDetails','ContactDetails'])->get();
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

        // dd($request['contact_number']);
        $this->validate($request,[
            'arena' => 'required|string',
            'address' => 'required|string|max:191',
            'operator' => 'required|string',
            // 'contact_number' => 'required|numeric',
         
        ]);

        $arena =  arena::create([
            'area_code' => $request['area_code'],
            'arena' => $request['arena'],
            'address' => $request['address'],
            'operator' => $request['operator'],
            'contact_number' => 'xxxxx',
        
        ]);
        

        

        foreach ($request['email'] as $email){
             Email::updateOrCreate([
         
                'area_code' => $arena->area_code,
                'email' => $email
            ]);
        }

        foreach ($request['contact_number'] as $contact){
            Contact::updateOrCreate([
               'area_code' => $arena->area_code,
               'contact_number' => $contact
           ]);
       }

      


        return $arena;
    }

    public function importArena(Request $request){
        $contactImport = arena::upsert($request->all(), ['area_code']);

        
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
            // 'contact_number' => 'required|numeric',
        ]);

        $arena = arena::with('BankDetails')->where('id',$id)->update([
            'arena' => $request['arena'],
            'address' => $request['address'],
            'operator' => $request['operator'],
            'contact_number' => 'xxxxxxx',

        ]);
   
            foreach ($request['email'] as $email){
                    if(!is_array($email)){
                        $data = Email::Create([
                            // 'arena_id' => $request['id'],
                            'area_code' => $request['area_code'],
                            'email' => $email
                        ]);
                     }
            }

            foreach ($request['contact_number'] as $contact){
                if(!is_array($contact)){
                    $data = Contact::Create([
                        'area_code' => $request['area_code'],
                        'contact_number' => $contact
                    ]);
                 }
        }
  
          
       
        return ['message' => 'Updated the arena details'];
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
   
        if($email || $contact){
            $email->delete();
           
        }
      
        $arena->delete();

        return ['message' => 'User Deleted'];
    }
}
