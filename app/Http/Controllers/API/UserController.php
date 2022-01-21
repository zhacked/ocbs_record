<?php

namespace App\Http\Controllers\API;

use view;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Models\import;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;

class UserController extends Controller
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

        return User::latest()->get();
    }


    public function getUserTeam(Request $request, $teamId) {
        $userTeam = User::with(['positionDetails','teamDetails'])->where('team_id', $teamId)->get();
      
      
        return $userTeam;
    }

    public function getStaffs() {
        $getStaffs = User::with(['positionDetails','teamDetails'])->where('type','!=','admin')->whereNull('team_id')->get();

        return $getStaffs;
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
            'password' => 'required|string|min:6'
        ]);

        return User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'team_id' => $request['team_id'],
            'position_id' => $request['position_id'],
            'assign' => $request['assign'],
            'password' => Hash::make($request['password']),
        ]);
    }


    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
    
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);


        $currentPhoto = $user->photo;
            if($request->photo != $currentPhoto){
                $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

                Image::make($request->photo)->save(public_path('image/profile/').$name);
                $request->merge(['photo' => $name]);

                $userPhoto = public_path('image/profile/').$currentPhoto;
                if(file_exists($userPhoto)){
                    @unlink($userPhoto);
                }

            }

            if(!empty($request->password)){
                $request->merge(['password' => Hash::make($request['password'])]);
            }


        $user->update($request->all());
        return ['message' => "Success"];
    }

    public function profile()
    {
        return auth('api')->user();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validate_user($password)
    {
    
        if (Hash::check($password, Auth::user()->password)) {
            // $artisan = Artisan::call('backup:run',[
            //     '--only-db' => true,
            // ]);
             $import =  import::truncate();
             return 'success';
        }else{
            return 'error';
        }
        
       
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
     
        $user = User::findOrFail($id);
        
     
        if($request->type == 'admin'){
            $request['team_id'] = null;
           $request['position_id'] = null;
             $request['assign'] =  null;
        }

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6'
        ]);

        $user->update([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'team_id' => $request['team_id'],
            'position_id' => $request['position_id'],
            'assign' => $request['assign'],
            'password' => Hash::make($request['password'])
        ]);
        return ['message' => 'Updated the user info'];
    }

    public function updateUserTeam(Request $request, $id){
        $user = User::findOrFail($id);
        // $userTeam = User::with(['positionDetails','teamDetails'])->where('team_id', $teamId)->get();

        $user->update([
            'team_id' => $request['team_id'],
        ]);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return ['message' => 'User Deleted'];
    }


}
