<?php

namespace App\Http\Controllers\API;
use Exception;
use App\Models\User;
use App\Models\Email;
use Illuminate\Http\Request;
use App\Exports\importExport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

class EmailController extends Controller
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
        // dd($request->all());
      
    //     foreach ($request->all() as $data){
         
    //         if(!Email::where('email',$data['email'])->where('area_code', $data['area_code'])->exists()) {
    //              Email::updateOrCreate([
    //                 'area_code' => $data['area_code'],
    //                 'email' => $data['email']
    //             ]);
    //         }
      
    //    }

        
        $emailImport = Email::upsert($request->all(),['area_code']);

     
        
        return  $emailImport;
        
    //    return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


       
    }

   

}
