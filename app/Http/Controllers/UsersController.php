<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('manage_users');
    }

    //get the list of all users
    public function getAllUsers(){
        $user_id = auth()->user()->id;
        $user_role = auth()->user()->user_role;


        if (request()->ajax()) {
            //if user is admin
            if($user_role == 1){
                return DB::table('users')
                ->select('users.id','users.name','users.email','users.created_at',
                    DB::raw("(CASE WHEN users.user_role = 1 THEN 'Administrator' "
                                . "WHEN users.user_role  = 0 THEN 'Default' "
                                . "WHEN users.user_role  = 2 THEN 'Event Organiser' "
                                . "ELSE 'Unknown' END) AS user_role"),
                    DB::raw("(CASE WHEN users.status = 1 THEN 'Active' "
                                . "ELSE 'Deactivated' END) AS user_status"),'users.status')               
                ->orderBy('users.created_at','desc')
                ->get();
            }

            return DB::table('users')
            ->select('users.id','users.name','users.email','users.created_at',
                DB::raw("(CASE WHEN users.user_role = 1 THEN 'Administrator' "
                            . "WHEN users.user_role  = 0 THEN 'Default' "
                            . "WHEN users.user_role  = 2 THEN 'Event Organiser' "
                            . "ELSE 'Unknown' END) AS user_role"),
                DB::raw("(CASE WHEN users.status = 1 THEN 'Active' "
                            . "ELSE 'Deactivated' END) AS user_status"),'users.status')
            ->where([
                ['users.created_by', '=', $user_id]
            ])                
            ->orderBy('users.created_at','desc')
            ->get();
        }
        
    }

    //get a single user
    public function getSingleUser($userId)
    {

        $user_dets = DB::table('users')
            ->select('users.id','users.name',
                        'users.email','users.created_at',
                DB::raw("(CASE WHEN users.user_role = 1 THEN 'Administrator' "
                . "WHEN users.user_role  = 2 THEN 'Event Organiser' "
                    . "WHEN users.user_role  = 0 THEN 'Default' "
                    . "ELSE 'Unknown' END) AS role"),'users.user_role',
                DB::raw("(CASE WHEN users.status = 1 THEN 'Active' "
                            . "ELSE 'Deactivated' END) AS user_status"),
                'users.status')
            ->where([
                ['users.id', '=', $userId]
            ])    
            ->first();
        
        return response()->json($user_dets);
    }

    //deelet a user
    public function destroy()
    {
        $userId = request()->input('user_id');

        $deleteRes = DB::table('users')
                            ->where([
                                ['id', '=', $userId]
                            ])
                            ->delete();
        if($deleteRes){
            return response()->json(['success'=>'User deleted successfully']);
        }else{
            return response()->json(['error'=>'Failed to delete user']);
        }
    }

    //create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|max:191',
            'user_email' => 'required|email',
            'user_password' => 'required|string',
            'user_status' => 'required|numeric',
            'user_role' => 'nullable'
        ]);

        $salt1 = sha1(rand());
        $salt = substr($salt1, 0, 10);

        $user_id = auth()->user()->id;
        $name = request()->input('user_name');
        $email = request()->input('user_email');
        $status = request()->input('user_status');
        if(empty($validated['user_role'])){
            $role = 0;
        }else{
            $role = request()->input('user_role');
        }
        $password = bcrypt(request()->input('user_password'));

        $insertRes = DB::table('users')->insertGetId(array('name' => $name,'email' => $email, 
            'password' => $password, 'created_at' => now(), 'created_by' => $user_id,
            'status' => $status, 'user_role' => $role, 'salt' => $salt));
            
        if($insertRes){
            return response()->json(['success'=>'User created successfully']);
        }else{
            return response()->json(['error'=>'Failed to create user']);
        } 
    }

    //save a user
    public function update($userId)
    {
        $validated = request()->validate([
            'user_name' => 'required|max:191',
            'user_email' => 'required|email',
            'user_status' => 'required|numeric',
            'user_role' => 'nullable'
        ]);

        $user_id = auth()->user()->id;
        $name = request()->input('user_name');
        $email = request()->input('user_email');
        $status = request()->input('user_status');
        if(empty($validated['user_role'])){
            $role = 0;
        }else{
            $role = request()->input('user_role');
        }

        $updateRes = DB::table('users')
            ->where('id', $userId)
            ->update(array('name' => $name,'email' => $email, 
            'updated_at' => now(),'status' => $status, 
            'user_role' => $role));

        if($updateRes){
            return response()->json(['success'=>'User updated successfully']);
        }else{
            return response()->json(['error'=>'Failed to update user']);
        } 
    }

    //change user status fom active to deactivated and vice verse
    public function changeUserStatus(){
        $current_Status = request()->input('current_Status');
        $user_id = request()->input('user_id');
        $new_status = 0;
        $message = "deactivated";

        //user is being activated
        if($current_Status == 0){
            $new_status = 1;
            $message = "activated";
        }

        $updateStatus = DB::table('users')
            ->where([
                ['id', '=', $user_id]
            ])
            ->update(array('status' => $new_status));

        return ($updateStatus) ? 
        response()->json(['success'=>'User '.$message.' successfully']) :
        response()->json(['error'=>'Ooops! An error occured during user status change']);

    }

    //import users to db
    public function importUsers() {
        $user_id = auth()->user()->id;

        $validatedFile = request()->validate([
           'users_file' => 'required|mimes:xls,xlsx,txt,csv',
       ]);
        
        $fileName = request()->file('users_file')->getClientOriginalName();
        
        $userImport = new UsersImport($user_id );
        $userImport->import(request()->file('users_file'));

        // foreach ($userImport->failures() as $failure) {
        //     $failure->row(); // row that went wrong
        //     $failure->attribute(); // either heading key (if using heading row concern) or column index
        //     $failure->errors(); // Actual error messages from Laravel validator
        //     $failure->values(); // The values of the row that has failed.
        // }

        if(count($userImport->failures()) > 0){
            return response()->json(['error'=>$userImport->failures()]);
        }

        return response()->json(['success'=>'Users imported successfully']);

    }

    //download the template for bulk user upload
    public function downloadUserUploadTemplate(){

        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        $file_path = base_path('public/uploads/user_upload_template.csv');

        return response()->download($file_path, 'user_upload_template.csv');
    }
}
