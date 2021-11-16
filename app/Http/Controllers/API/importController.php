<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\arena;
use App\Models\import;

class ImportController extends Controller
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
        return import::with(['arenaDetails','BankDetails'])->get();
    }

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
        
     
        foreach ($request->all() as $data ){
        
        $arena= arena::where('arena', $data['arenaName'])->first();

           $import =  import::create([
                'arena_id' =>  $arena == null ? null : $arena->id,
                'arena_name' => $data['arenaName'],
                'meron' => $data['meron'],
                'wala' => $data['wala'],
                'total_meron_wala' => $data['total'],
                'total_payout_paid' => $data['payoutPaid'],
                'unclaimed' => $data['unclaimed'],
                'rake' => $data['rake'],
                'draw_cancelled' => $data['drawCancelled'],
                'draw_cancelled_paid' => $data['cDPaid'],
                'cancelled_unpaid' => $data['cUnpaid'],
                'draw_paid' => $data['drawPaid'],
                'draw_unpaid' => $data['dUnpaid'],
                'draw' => $data['draw'],
                'draw_unclaimed' => $data['drawUnclaimed'],
                'draw_gain_loss' => $data['drawGainLoss'],
                'draw_2_percent' => $data['draw2'],
                'type' => $data['type'],
            ]);
        }
        
        return  $import;
        

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
