<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\import;
use Maatwebsite\Excel\Excel;

class importController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:api');

    }

    public function index()
    {

        return import::all();
    }

    public function store(Request $request)
    {

        $request->validate([
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_file');
        $data = Excel::import($path)->get();
        dd($path);
        if($data->count() > 0)
            {
            foreach($data->toArray() as $key => $value)
                {
                foreach($value as $row)
                    {
                        $insert_data[] = array(
                        
                        );
                    }
                }

                if(!empty($insert_data))
                    {
                    DB::table('import')->insert($insert_data);
                    }
                }
            return back()->with('success', 'Excel Data Imported successfully.');
        }
     


}
