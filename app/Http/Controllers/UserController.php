<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Privillege;
use App\Models\Form;
use App\Models\Tournament;
use App\Models\UserAccess;
use App\Models\UserForm;
use App\Mail\SendMail;

class UserController extends Controller
{

    public function index(Request $request) 
    {
        $input=$request->all();
        $pageLimit=20;
        $data['paginationRoute']="user"; 

        $userId= Auth::guard('web')->user()->id;
        $loginUser=UserAccess::with('PrivillegeMaster')->where('user_id',$userId)->get();
        $data['loginuserPrivilleges']=$loginUser->flatMap->PrivillegeMaster;

        $sql=User::query();
        
        $sql=$sql->leftJoin('role_master','users.role_id','role_master.id');
        if(isset($input['search'])){
            $search=$input['search'];
            $sql=$sql->where(function($query) use ($search){  
                        $query->where('users.name','LIKE','%'.$search.'%')
                        ->orWhere('role_master.title','LIKE','%'.$search.'%');
                    });
        }
        $sql=$sql-> where('users.role_id','>','0')
                    ->where('users.admin','=','0')
                    ->where('users.type','!=','super_admin')
                    ->select('users.*','role_master.title');
        
        $data['listData']=$sql->paginate($pageLimit);
        //print_r($data);exit;
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
            $user->save();
            
            UserAccess::where('user_id',$input['id'])->where('type','privillege')->delete();
            UserAccess::where('user_id',$input['id'])->where('type','tournament')->update(['status'=>'0']);
            UserForm::where('user_id',$input['id'])->delete();
            //exit;
            
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
                    $tournamentdata=[];
                    /* if(isset($input['tournamentuserAccessId'][$tournamentVal])){
                        $tournamentdata['id']=$input['tournamentuserAccessId'][$tournamentVal];
                    } */
                    $tournamentdata['user_id']=$user->id;
                    $tournamentdata['privillege_id']=NULL;
                    $tournamentdata['tournament_id']=$tournamentVal;
                    $tournamentdata['type']="tournament";
                    UserAccess::create($tournamentdata);
                    if(isset($input['forms'])){
                        foreach($input['forms'] as $key=>$formval){
                            $tournamentformdataupdate=[];
                            if(isset($input['userFormId'][$tournamentVal]) && isset($input['userFormId'][$tournamentVal][$formval])){
                                $tournamentformdataupdate['id']=$input['userFormId'][$tournamentVal][$formval];
                            }
                            $tournamentformdataupdate['user_id']=$user->id;
                            $tournamentformdataupdate['tournament_id']=$tournamentVal;
                            $tournamentformdataupdate['form_id']=$formval;
                            $tournamentformdataupdate['status']="1";
                            UserForm::create($tournamentformdataupdate);
                        }
                    }
                }
            }

            $message="Successfully Updated";
        }
        else{
            $userData=User::where('email',$input['email'])->first();
            if(!$userData){
                $input['admin']='0';
                //$input['password']=$this->random_strings(6);
                $password=123456;
                $input['password']=$password;
                $input['type']='user';
                $user=User::create($input);
                $message="Successfully Saved";


                $roleDetails=Role::with('Privilleges','Forms')->where('id',$input['role_id'])->first();
                //print_r($roleDetails->Forms);exit;
                if(isset($input['tournaments'])){
                    foreach($input['tournaments'] as $tournamentVal){
                        $data['user_id']=$user->id;
                        $data['tournament_id']=$tournamentVal;
                        $data['type']="tournament";
                        UserAccess::create($data);
                        foreach($roleDetails->Forms as $val){
                            $tournamentformdata['user_id']=$user->id;
                            $tournamentformdata['tournament_id']=$tournamentVal;
                            $tournamentformdata['form_id']=$val->form_id;
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
               
                $subject = "Your Account Created Successfully";
                $email_content = [
                    'subject'       => $subject,
                    'name'          => $input['name'],
                    'password'      => $password,
                    'email'         => $input['email'],
                ];
                $content = view('email.password', $email_content)->render();
                $to_data = [
                    'to_email'  => $input['email'],
                    'name'      => $input['name'],
                ];
               // SendMail::sendemail($to_data, $subject, $content);
                SendMail::sendemail($to_data, $subject, $content);

            }
            else{
                $message="User already exist";
                return redirect()->route('user')->with('deleteMessage',$message);
            }
        }
        
        return redirect()->route('user')->with('message',$message);
    }

    public function assign_tournament(Request $request)
    {
            $input=$request->all();
            $data['tournaments']=Tournament::orderBy('category')->get();
            $user=User::with('Forms','Tournaments')->find($input['id']);
            //$data['roleMaster']=Role::where('id',$user->role_id)->first();
            $data['formData']=$user;
        return view('user.assign_tournament',$data);
    }

    public function change_tournament(Request $request)
    {
        $input=$request->all();
        //print_r($input);exit;
        $user=User::find($input['id']);
        if($user->admin == 1){
            $route="admin";
        }
        else{
            $route="user";
        }
        UserAccess::where('user_id',$input['id'])->where('type','tournament')->update(['status'=>'0']);
        UserForm::where('user_id',$input['id'])->update(['active'=>'0']);

        $roleDetails=Role::with('Forms')->where('id',$user->role_id)->first();
                //print_r($roleDetails->flatMap->Forms);exit;
                if(isset($input['tournaments'])){
                    foreach($input['tournaments'] as $tournamentVal){
                        $data['user_id']=$input['id'];
                        $data['tournament_id']=$tournamentVal;
                        $data['type']="tournament";
                        UserAccess::create($data);
                        foreach($roleDetails->Forms as $val){
                            $tournamentformdata['user_id']=$input['id'];
                            $tournamentformdata['tournament_id']=$tournamentVal;
                            $tournamentformdata['form_id']=$val->form_id;
                            $tournamentformdata['status']="1";
                            $tournamentformdata['active']="1";
                            UserForm::create($tournamentformdata);
                        }
                    }
                }


        $message="Successfully Updated Tournament";
        return redirect()->route($route)->with('message',$message);
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


    public function UAreset_psw(Request $request)
    {   
        $input=$request->all();
        $user=User::find($input['id']);
        $password=$this->random_strings(6);
        $user->update(['password' => Hash::make($password)]);

        $subject = "Your Password Reset Successfully";
                $email_content = [
                    'subject'       => $subject,
                    'name'          => $user->name,
                    'password'      => $password,
                    'email'         => $user->email,
                ];
                $content = view('email.password', $email_content)->render();
                $to_data = [
                    'to_email'  => $user->email,
                    'name'      => $user->name,
                ];
               // SendMail::sendemail($to_data, $subject, $content);
                SendMail::sendemail($to_data, $subject, $content);


        $message="Please check your mail for new password";
        return redirect()->back()->with('message',$message);
    }

    public function user_transfer(Request $request)
    { 
        $input=$request->all();
        
        $user=User::find($input['id']);

        if($user->admin == 1){
            $type="admin";
        }
        else{
            $type="user";
        }
        $data['formData']=$user;
        $data['users']=User::where('type',$type)->get();
        return view('user.transfer_user',$data);
    }

    public function user_transfer_store(Request $request)
    { 
        $input=$request->all();
        //print_r($input);exit;
        $user=User::find($input['id']);
        $userAccessUpdate=UserAccess::where('user_id',$input['id'])->update(['user_id'=>$input['userId']]);
        $userFormUpdate=UserForm::where('user_id',$input['id'])->where('active','1')->update(['user_id'=>$input['userId']]);
        if($user->admin == 1){
            $route="admin";
        }
        else{
            $route="user";
        }
        $message="Successfully Transfered User";
        return redirect()->route($route)->with('message',$message);
    }

    
    
     
}