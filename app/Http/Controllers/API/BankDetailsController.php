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
        return BankAccount::latest()->get();
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
    public function create()
    {
      
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
            'arena_id' => 'required|numeric',
            'bank_name' => 'required|string|max:191',
            'bank_number' => 'required|string'
        ]);

        return BankAccount::create([
            'arenas_id' => $request['arena_id'],
            'bank_name' => $request['bank_name'],
            'bank_number' => $request['bank_number'],
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
            'arena_id' => 'required|numeric',
            'bank_name' => 'required|string|max:191',
            'bank_number' => 'required|string'
        ]);

        $bank->update($request->all());
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
