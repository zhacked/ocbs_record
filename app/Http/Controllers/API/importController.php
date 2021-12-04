<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Models\arena;
use App\Models\import;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Support\Authorization\AuthorizationUserTrait;
use  Spatie\DbDumper\Databases\MySql;
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
        return import::with(['BankDetails','arenaDetails.BankDetails'])->whereNull('status')->get();
      
    }

    public function withstatus()
    {
        return import::with(['BankDetails','arenaDetails.BankDetails'])->whereNotNull('status')->get();
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SavePrimaryBank($id)
    {
        $arena = arena::findOrFail($id);
      
        if($arena->bank_id == null){
                $bankOwn = BankAccount::where('arenas_id',$id)->first();
                $arena->bank_id = $bankOwn->id;
                $arena->update();
        }
     
        return BankAccount::where('id',$arena->bank_id)->first();
    }
    public function bankaccountfilter($id)
    {
        return BankAccount::where('id',$id)->first();
    }
    // public function updatebankaccount($id,$bank_id){
     
    //    return  arena::where('id',$id)->update([
    //         'bank_id' => $bank_id
    //     ]); 
    // }
    
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
                'arena_name' => $data['arenaName'],
                'date_of_soa'=> $data['eventCreated'],
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
                'totalOthers'=> $data['totalOthers'],
                'salesDeductionTablet'=> $data['salesDeductionTablet'],
                'netOperatorsCommission'=> $data['netOperatorsCommission'],
                'otherCommissionIntel05' => $data['otherCommissionIntel05'],
                'consolidatorsCommission'=> $data['consolidatorsCommission'],
                'safetyFund'=> $data['safetyFund'],
                'paymentForOutstandingBalance'=> $data['paymentForOutstandingBalance'],
                'systemErrorCOArmsi'=> $data['systemErrorCOArmsi'],
                'cashLoad'=> $data['cashLoad'],
                'cashWithdrawal'=> $data['cashWithdrawal'],
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
    public function bankdetialsfilter($id)
    {
        return BankAccount::where('arenas_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function arenastatus($arena_name,request $request)
    {   
        $amount = json_decode(json_encode($request->data));
        $group =  json_decode(json_encode($amount));

          return  import::where('arena_name',$arena_name)->update([
            'status' => 'done',
            'Soa_number'=> $group->depositReplenishText->number,
            'group' => $group->depositReplenishText->totalText,
            'for_total' => $amount->depositReplenish

        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function countdata()
    {
        $arena = arena::count();
        $user = User::count();
        $import = Import::whereNull('status')->count();

        return Response()->json([
            'arena' => $arena,
            'user' => $user,
            'import' => $import
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


       
    }

    public function depositedata(){
        $deposit =  import::with(['BankDetails','arenaDetails.BankDetails'])->whereGroup('Deposit')->whereNotNull('status')->get();
        $reflenish =  import::with(['BankDetails','arenaDetails.BankDetails'])->whereGroup('Reflenish')->whereNotNull('status')->get();
        return Response()->json([
            'rf' => $reflenish,
            'dp' => $deposit
        ]);
    }
    public function truncate_data(){
        // $import =  import::truncate();
        $dump =  MySql::create()
        ->setDbName('finance')
        ->setUserName('root')
        ->setPassword('')
        ->dumpToFile('dump.sql');;
    }
}
