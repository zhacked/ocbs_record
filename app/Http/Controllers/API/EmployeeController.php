<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $computed =  employee::where('group','computed')->get();
        $prepared = employee::where('group','prepared')->get();
        $checked = employee::where('group','checked')->get();
        $employee = employee::all();
        return response()->json([
            'computed' => $computed,
            'prepared' => $prepared,
            'checked' => $checked,
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    

    public function selectedbyUser(Request $request, $old)
    {   
<<<<<<< HEAD
        dd($id);
        $checked = employee::where('group','checked')->where('assign','1')->count();
        $groups = employee::where('group',$group)->where('assign','1')->first();
        $employee = employee::where('id',$id)->first();
        
=======
>>>>>>> 26cc0a164f68cfb786042eb860bd1118ce2f561e

            //   dd($request['new']);

            if($old != 'undefined') {

<<<<<<< HEAD
    //     if($new) {
    //         $newed = employee::where('id',$new)->first();

    //         $newed->update([
    //             'assign' => true
    //         ]);
           
    //    }
    
=======
                $olded = employee::where('id',$old)->first();

                $olded->update([ 'assign' => false
            ]);

        }
            if($request['new']) {
                $newed = employee::where('id',$request['new'])->first();
                $newed->update([
                    'assign' => true
                ]);
            
            }

            return true;
   
>>>>>>> 26cc0a164f68cfb786042eb860bd1118ce2f561e
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'contact' => 'required',
            'address' => 'required',
            'group' => 'required',
            'position' => 'required',
        ]);

        return employee::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'contact' => $request['contact'],
            'address' => $request['address'],
            'group' => $request['group'],
            'position' =>$request['position'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function countEmployee()
    {
        $computed =  employee::where('group','computed')->where('assign','1')->count();
        $prepared = employee::where('group','prepared')->where('assign','1')->count();
        $checked = employee::where('group','checked')->where('assign','1')->count();

        return response()->json([
            'computed' => $computed,
            'prepared' => $prepared,
            'checked' => $checked,
        ]);
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
        $employee = employee::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'contact' => 'required',
            'address' => 'required',
            'group' => 'required',
            'position' => 'required',
        ]);

        $employee->update($request->all());
        return ['message' => 'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $employee = employee::findOrFail($id);
        // delete the user

        $employee->delete();

        return ['message' => 'User Deleted'];
    }
}
