<?php

namespace App\Http\Controllers\API;
use Exception;
use App\Models\User;
use App\Models\arena;
use App\Models\import;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Exports\importExport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

class importController extends Controller
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
        return BankAccount::where('arenas_id',$id)->get();
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
                'areaCode' => $data['areaCode'],
                'refNo' => $data['refNo'],
                'arena_name' => $data['arenaName'],
                'date_of_soa'=> $data['eventDate'],
                'meron' => $data['meron'],
                'wala' => $data['wala'],
                'total_meron_wala' => $data['totalMWBets'],
                'total_payout_paid' => $data['totalPayoutPaid'],
                'unclaimed' => $data['totalUnclaimed'],
                'rake' => $data['rake'],
                'draw_cancelled' => $data['totalCancelledBets'],
                'draw_cancelled_paid' => $data['totalCDPaid'],
                'cancelled_unpaid' => $data['totalCUnpaid'],
                'draw_paid' => $data['totalDrawPaid'],
                'draw_unpaid' => $data['dUnpaid'],
                'draw' => $data['totalDrawBets'],
                'draw_unclaimed' => $data['drawUnclaimed'],
                'draw_unpaid' => $data['dUnpaid'],
                'type' => $data['type'],
                'totalOthers'=> $data['totalOthers'],
                'salesDeductionTablet'=> $data['salesDeduction'],
                'netOperatorsCommission'=> $data['netOperatorsCommission'],
                'otherCommissionIntel05' => $data['otherCommissionIntel'],
                'consolidatorsCommission'=> $data['consolidatorsCommission'],
                'safetyFund'=> $data['safetyFund'],
                'paymentForOutstandingBalance'=> $data['paymentForOutstandingBalance'],
                'systemErrorCOArmsi'=> $data['systemErrorCOArmsi'],
                'cashLoad'=> $data['cashLoad'],
                'cashWithdrawal'=> $data['cashWithdrawal'],
                'total_win_mobile'=> $data['totalMWMobile'],
                'draw_mobile'=> $data['totalDrawMobile'],
                'exempted'=> $data['exempted'],
                'netWinLoss' => $data['netWinLoss'],
                'mwTwo' => $data['mwTwo'],
                'drawTwo' => $data['drawTwo'],
                'mwTwoMobile' => $data['mwTwoMobile'],
                'drawTwoMobile' => $data['drawTwoMobile'],
                'for_total' => $data['depositReplenish'],
                'group' => $data['group']

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
    public function arenastatus($areaCode)
    {   
        // dump($arena_name);
        $import = import::where('areaCode',$areaCode)->update([
            'status' => 'done',
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
        $reflenish =  import::with(['BankDetails','arenaDetails.BankDetails'])->whereGroup('Replenish')->whereNotNull('status')->get();
        return Response()->json([
            'rf' => $reflenish,
            'dp' => $deposit
        ]);
    }
    public function ConvertToExcel($data){
        return import::Where('updated_at',$data)
        ->whereGroup('Deposit')
        ->whereNotNull('status')->get();
      
    }

    public function artisan(){
        Artisan::call('backup:run ',[
            '--only-db' => true
        ]);
        return redirect()->back();
         
       }

}
