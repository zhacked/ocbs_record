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
    public function index(Request $request)
    {
        $soa = import::with(['BankDetails',
            'arenaDetails.BankDetails',
            'arenaDetails.EmailDetails',
            'arenaDetails.ContactDetails',
            'arenaDetails.UserTeam.userDetails.positionDetails'
        ]);

        // if($request->has('per_page')) {
        //     $perPage = $request->input('per_page');
        //     return $soa->whereNull('status')->paginate($perPage);
        // } else {
            return $soa->whereNull('status')->get();
        // }


    }

    public function importDateRange(Request $request, $from, $to){

        $soaDateRange = import::with(['BankDetails',
        'arenaDetails.BankDetails',
        'arenaDetails.EmailDetails',
        'arenaDetails.ContactDetails',
        'arenaDetails.UserTeam.userDetails.positionDetails'
        ])->whereBetween('date_of_soa',[$from, $to]);


        return $soaDateRange->get();
    }

    //converted
    public function withstatus(Request $request)
    {
        $soa = import::with(['BankDetails',
            'arenaDetails.BankDetails',
            'arenaDetails.EmailDetails',
            'arenaDetails.ContactDetails',
            'arenaDetails.UserTeam.userDetails.positionDetails'
        ]);

        // if($request->has('per_page')) {
        //     $perPage = $request->input('per_page');
        //     return $soa->whereNotNull('status')->paginate($perPage);
        // } else {
            return $soa->whereNotNull('status')->get();
        // }

    }

    public function searchSoa(Request $request) {
            return  import::with(['BankDetails',
            'arenaDetails.BankDetails',
            'arenaDetails.EmailDetails',
            'arenaDetails.ContactDetails',
            'arenaDetails.UserTeam.userDetails.positionDetails'
            ])->where('arena_name','like', '%'.$request->query('search').'%')->get();


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
                $bankOwn = BankAccount::where('area_code',$id)->first();
                $arena->bank_id = $bankOwn->id;
                $arena->update();
        }

        return BankAccount::where('id',$arena->bank_id)->first();
    }
    public function bankaccountfilter($id)
    {
        return BankAccount::where('area_code',$id)->get();
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
        return BankAccount::where('area_code',$id)->get();
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
//         ->whereNotNull('status')
// ->whereNotNull('status')
        $deposit =  import::with(['BankDetails','arenaDetails.BankDetails'])->where('group','Deposit')->get();
        $reflenish =  import::with(['BankDetails','arenaDetails.BankDetails'])->where('group','Replenish')->get();
        return Response()->json([
            'rf' => $reflenish,
            'dp' => $deposit
        ]);
    }
    public function depositReplenishDateRange($from, $to){

                $deposit =  import::with(['BankDetails','arenaDetails.BankDetails'])->whereBetween('date_of_soa', [$from, $to])->where('group','Deposit')->get();
                $reflenish =  import::with(['BankDetails','arenaDetails.BankDetails'])->whereBetween('date_of_soa', [$from, $to])->where('group','Replenish')->get();
                return Response()->json([
                    'fr' => $reflenish,
                    'soa' => $deposit
                ]);
            }
    public function ConvertToExcel($group,$data){
        // ->whereNotNull('status')
        // dd($group);

       return import::where('group',$group)
                        ->where('date_of_soa',$data)
                        ->get();
    }

    public function Clearfilterbydate(request $request){

        $status = $request->tab == 'converted' ? 'done' : null;

        $delete = import::whereBetween('date_of_soa',[$request->from, $request->to])
                        ->where('status',$status)
                        ->delete();
        return $delete;
    }



}
