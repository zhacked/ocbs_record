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
        return import::with(['BankDetails','arenaDetails.BankDetails','arenaDetails.EmailDetails'])->whereNull('status')->get();
      
    }

    public function withstatus()
    {
        return import::with(['BankDetails','arenaDetails.BankDetails','arenaDetails.EmailDetails'])->whereNotNull('status')->get();
        
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
      
        // dd($request->all());

        $import = import::upsert($request->all(),['codeEvent']);

        // foreach ($request->all() as $data ){
        
        // $arena= arena::where('arena', $data['arena_name'])->first();
            
        //    $import =  import::create([
        //         'areaCode' => $data['areaCode'],
        //         'codeEvent' => $data['codeEvent'],
        //         'refNo' => $data['refNo'],
        //         'arena_name' => $data['arena_name'],
        //         'date_of_soa'=> $data['date_of_soa'],
        //         'meron' => $data['meron'],
        //         'wala' => $data['wala'],
        //         'total_meron_wala' => $data['total_meron_wala'],
        //         'total_payout_paid' => $data['total_payout_paid'],
        //         'unclaimed' => $data['unclaimed'],
        //         'rake' => $data['rake'],
        //         'draw_cancelled' => $data['draw_cancelled'],
        //         'draw_cancelled_paid' => $data['draw_cancelled_paid'],
        //         'cancelled_unpaid' => $data['cancelled_unpaid'],
        //         'draw_paid' => $data['draw_paid'],
        //         'draw_unpaid' => $data['draw_unpaid'],
        //         'draw' => $data['draw'],
        //         'draw_unclaimed' => $data['draw_unclaimed'],
        //         'draw_unpaid' => $data['draw_unpaid'],
        //         'type' => $data['type'],
        //         'totalOthers'=> $data['totalOthers'],
        //         'salesDeductionTablet'=> $data['salesDeductionTablet'],
        //         'netOperatorsCommission'=> $data['netOperatorsCommission'],
        //         'otherCommissionIntel05' => $data['otherCommissionIntel05'],
        //         'consolidatorsCommission'=> $data['consolidatorsCommission'],
        //         'safetyFund'=> $data['safetyFund'],
        //         'paymentForOutstandingBalance'=> $data['paymentForOutstandingBalance'],
        //         'systemErrorCOArmsi'=> $data['systemErrorCOArmsi'],
        //         'cashLoad'=> $data['cashLoad'],
        //         'cashWithdrawal'=> $data['cashWithdrawal'],
        //         'total_win_mobile'=> $data['total_win_mobile'],
        //         'draw_mobile'=> $data['draw_mobile'],
        //         'exempted'=> $data['exempted'],
        //         'netWinLoss' => $data['netWinLoss'],
        //         'mwTwo' => $data['mwTwo'],
        //         'drawTwo' => $data['drawTwo'],
        //         'mwTwoMobile' => $data['mwTwoMobile'],
        //         'drawTwoMobile' => $data['drawTwoMobile'],
        //         'for_total' => $data['for_total'],
        //         'group' => $data['group']

        //     ]);
        // }
        
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
    public function arenastatus(Request $request)
    {   
        // dump($arena_name);
        // $import = import::where('areaCode',$areaCode)->update([
        //     'status' => 'done',
        // ]); 
      
        $import = import::upsert( $request->all(),['codeEvent']);
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
        
        return import::Where('date_closed',$data)
        ->whereNotNull('status')->get();
      
    }

   

}
