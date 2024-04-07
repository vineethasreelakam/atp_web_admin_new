<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Privillege;
use App\Models\Form;
use App\Models\Tournament;
use App\Models\UserAccess;
use App\Models\UserForm;


class UserController extends Controller
{

    public function index() 
    {
        $pageLimit=20;
        $data['paginationRoute']="user"; 
    	$data['listData'] = User::with('Role')->where('admin','0')->where('role_id','>','0')->paginate($pageLimit);
        return view('user.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        $data['formData']=new User;
        $data['role']=Role::where('admin','0')->get();
        $data['roleMaster']=new Role;
        $data['privilleges']=Privillege::get();
        $data['forms']=Form::get();
        $data['tournaments']=Tournament::orderBy('category')->get();
        //print_r($data['role']);exit;
        if(isset($input['id'])){
            //$data['formData']=Role::find($input['id']);
            $user=User::with('Privilleges','Forms','Tournaments')->find($input['id']);
            $data['roleMaster']=Role::where('id',$user->role_id)->first();
            $data['formData']=$user;
            //Print_r($data['roleMaster']);exit;
        }
        return view('user.create',$data);
    }
    public function store(Request $request) 
    {
        $input=$request->all();
        //print_r($input);exit;
        if(isset($input['id'])){
            $user=User::find($input['id']);
            $user->name=$input['name'];
            $user->email=$input['email'];
            $user->role_id=$input['role_id'];
            $user->admin=$input['admin'];
            $user->update();
            
            UserAccess::where('user_id',$input['id'])->where('type','privillege')->delete();
            UserAccess::where('user_id',$input['id'])->where('type','tournament')->delete();
            UserForm::where('user_id',$input['id'])->delete();
            
            if(isset($input['privilleges'])){
                foreach($input['privilleges'] as $key=>$privillegeVal){
                    $data['id']=$input['userAccessId'][$key];
                    $data['user_id']=$user->id;
                    $data['privillege_id']=$privillegeVal;
                    $data['type']="privillege";
                    UserAccess::create($data);
                }
            }

            if(isset($input['tournaments'])){
                foreach($input['tournaments'] as $tournamentVal){
                    $tournamentdata['user_id']=$user->id;
                    $tournamentdata['privillege_id']=NULL;
                    $tournamentdata['tournament_id']=$tournamentVal;
                    $tournamentdata['type']="tournament";
                    UserAccess::create($tournamentdata);
                    if(isset($input['forms'])){
                        foreach($input['forms'] as $val){
                            $tournamentformdata['id']=$input['userFormId'][$key];
                            $tournamentformdata['user_id']=$user->id;
                            $tournamentformdata['tournament_id']=$tournamentVal;
                            $tournamentformdata['form_id']=$val;
                            $tournamentformdata['status']="1";
                            UserForm::create($tournamentformdata);
                        }
                    }
                }
            }

            if(isset($input['forms'])){
                foreach($input['forms'] as $val){
                    $formdata['id']=$input['userFormId'][$key];
                    $formdata['user_id']=$user->id;
                    $formdata['form_id']=$val;
                    $formdata['status']="1";
                    UserForm::create($formdata);
                }
            }
            $message="Successfully Updated";
        }
        else{
            $userData=User::where('email',$input['email'])->first();
            if(!$userData){
                $input['admin']='0';
                $input['password']=$this->random_strings(6);
                $input['type']='user';
                $user=User::create($input);
                $message="Successfully Saved";


                $roleDetails=Role::with('Privilleges','Forms')->where('id',$input['role_id'])->first();

                if(isset($input['tournaments'])){
                    foreach($input['tournaments'] as $tournamentVal){
                        $data['user_id']=$user->id;
                        $data['tournament_id']=$tournamentVal;
                        $data['type']="tournament";
                        UserAccess::create($data);
                        foreach($roleDetails->Forms as $val){
                            $tournamentformdata['user_id']=$user->id;
                            $tournamentformdata['tournament_id']=$tournamentVal;
                            $tournamentformdata['form_id']=$val;
                            $tournamentformdata['status']="1";
                            UserForm::create($tournamentformdata);
                        }
                    }
                }

                if($roleDetails->Privilleges){
                    foreach($roleDetails->Privilleges as $val){
                        $privillegedata['privillege_id']=$val->privillege_id;
                        $privillegedata['user_id']=$user->id;
                        $privillegedata['type']="privillege";
                        UserAccess::create($privillegedata);
                    }
                }

                if($roleDetails->Forms){
                    foreach($roleDetails->Forms as $val){
                        $formdata['user_id']=$user->id;
                        $formdata['form_id']=$val->form_id;
                        $formdata['status']="1";
                        UserForm::create($formdata);
                    }
                }
            }
            else{
                $message="User already exist";
                return redirect()->route('user')->with('deleteMessage',$message);
            }
        }
        
        return redirect()->route('user')->with('message',$message);
    }

    public function destroy(Request $request,$id)
    {
        $user=User::find($id);
        $user->delete();
        UserAccess::where('user_id',$id)->delete();
        UserForm::where('user_id',$id)->delete();
        $message="Successfully Deleted the Record";
        return redirect()->route('user')->with('deleteMessage',$message);
    }

    public function changeStatus(Request $request,$id)
    {
        $user=User::find($id);
        if($user->status==1){
            $user->status='0';
        }
        else{
            $user->status='1';
        }
        $user->save();
        $message="Successfully Changed Status";
        return redirect()->route('user')->with('message',$message);
    }

    public function random_strings($length_of_string)
    {
  
     // String of all alphanumeric character
     $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  
     // Shuffle the $str_result and returns substring
     // of specified length
     return substr(str_shuffle($str_result),
                        0, $length_of_string);
    }
     
    
     
}