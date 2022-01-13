<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\arena;
class BankDetailsController extends Controller
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
        return BankAccount::with(['arenaDetails'])->latest()->get();
    }
    public function Companybank()
    {
        return BankAccount::with(['arenaDetails'])->where('isAdmin',true)->get();
    }

    public function show_arena()
    {
          return arena::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function FilterBank($id)
    {
        return BankAccount::where('id',$id)->first();
    }

    public function arenaSelectedBank($bankId)
    {
         return BankAccount::where('id',$bankId)->first();
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
       
            'bank_name' => 'required|string|max:191',
            'bank_number' => 'required|string'
        ]);

        return BankAccount::create([
            'arenas_id' => $request['arenas_id'],
            'area_code' => $request['area_code'],
            'account_name'=> $request['account_name'],
            'bank_name' => $request['bank_name'],
            'bank_number' => $request['bank_number'],
            'isAdmin' => $request['isAdmin'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $bank = BankAccount::findOrFail($id);

        $this->validate($request,[  
            'bank_name' => 'required|string|max:191',
            'bank_number' => 'required|string'
        ]);

        $bank->update([
            'arenas_id' => $request['arenas_id'],
            'account_name'=> $request['account_name'],
            'bank_name' => $request['bank_name'],
            'bank_number' => $request['bank_number'],
            'isAdmin' => $request['isAdmin'],
        ]);
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
        $account = BankAccount::findOrFail($id);
    
        $account->delete();

        return ['message' => 'User Deleted'];
    }
}
