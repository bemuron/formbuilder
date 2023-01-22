<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function __construct()
    {
        //user should be signed in
        $this->middleware('auth');
    }

    //save a new form
    public function saveForm(Request $request)
    {
        $user_id = auth()->user()->id;

        $validated = $request->validate([
            'form_data' => 'required',
            'description' => 'required',
            'title' => 'required',
            'form_code' => 'nullable'
        ]);

        $loop = true;
        $code = $validated['form_code'];

        if(empty($validated['form_code']) ){
            while($loop == true){
                $code=mt_rand(0,9999999999);
                $code = sprintf("%'.09d",$code);
                $check =  DB::table('forms')
                    ->select('form_code')
                    ->where('form_code', '=', $code)
                    ->get();

                if(count($check) <= 0)
                    break;
            }
        }

        $formName = $code.".blade.php";
        $create_form = file_put_contents(base_path('resources/views/forms/').$formName,$validated['form_data']);
        if(!$create_form){
            return response()->json(['error'=>'Failed to save the form']);
        }

        if(empty($validated['form_code'])){
            $insertRes = DB::table('forms')->insertGetId(array('form_title' => $validated['title'],
                    'description' => $validated['description'], 'form_code' => $code, 
                    'created_by' => $user_id, 'form_name' => $formName, 'created_at' => now()));

            if($insertRes){
                return response()->json(['success'=>'Form saved successfully']);
            }else{
                return response()->json(['error'=>'Failed to save form']);
            }

        }

        $updateRes = DB::table('forms')
                    ->where('form_code', $validated['form_code'])
                    ->update(array('form_title' => $validated['title'],
                    'description' => $validated['description'], 'form_code' => $validated['form_code'], 
                    'form_name' => $formName, 'updated_at' => now()));

        if($updateRes){
            return response()->json(['success'=>'Form updated successfully']);
        }else{
            return response()->json(['error'=>'Failed to update form']);
        }

    }

    //get the list of all forms created by the logged in user
    public function getAllForms(){
        if (request()->ajax()) {
            return DB::table('forms')
            ->select('forms.id','forms.form_title',
                'forms.form_code','forms.form_name',
                    'forms.created_at','users.name AS created_by',
                DB::raw("IF(LENGTH(description) <= 40, forms.description,
                        CONCAT(LEFT(description, 40), '...')) AS description"))
            ->join('users', 'forms.created_by', '=', 'users.id')                
            ->orderBy('forms.created_at','desc')
            ->get();
        }
        
    }
}
