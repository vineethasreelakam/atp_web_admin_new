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
use App\Mail\SendMail;


class AdminController extends Controller
{

    public function index(Request $request) 
    {
        $pageLimit=20;
        $data['paginationRoute']="admin"; 

        $input=$request->all();

        $sql=User::query();
        $sql=$sql->with('Role');
        if(isset($input['search'])){
            $search=$input['search'];
            $sql=$sql->where('name','LIKE','%'.$search.'%');
        }
        $data['listData']=$sql->where('admin','1')->where('type','!=','super_admin')->paginate($pageLimit);
        return view('admin.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        $data['formData']=new User;
        $data['role']=Role::where('admin','1')->get();
        $data['roleMaster']=new Role;
        $data['privilleges']=Privillege::get();
        $data['forms']=Form::get();
        $data['tournaments']=Tournament::orderBy('category')->get();
        //print_r($data['role']);exit;
        if(isset($input['id'])){
            //$data['formData']=Role::find($input['id']);
            $user=User::with('Privilleges','Forms','Tournaments')->find($input['id']);
            $data['roleMaster']=Role::find($user->role_id);
            //$data['tournaments']=Tournament::whereIn('id',$user->Tournaments->tournament_id)->get();
            $data['formData']=$user;
            //Print_r($data['tournaments']);exit;
        }
        return view('admin.create',$data);
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
            UserAccess::where('user_id',$input['id'])->where('type','tournament')->update(['status'=>'0']);
            UserForm::where('user_id',$input['id'])->delete();

            if(isset($input['privilleges'])){
                foreach($input['privilleges'] as $val){
                    $data['user_id']=$user->id;
                    $data['privillege_id']=$val;
                    $data['type']="privillege";
                    UserAccess::create($data);
                }
            }

            if(isset($input['tournaments'])){
                foreach($input['tournaments'] as $tournamentVal){
                     $tournamentdata=[];
                   /* if(isset($input['tournamentuserAccessId']) && isset($input['tournamentuserAccessId'][$tournamentVal])){
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
                $input['admin']='1';
                //$input['password']=$this->random_strings(6);
                $password=123456;
                $input['password']=$password;
                $input['type']='admin';
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
                            $tournamentformdata['form_id']=$val->form_id;
                            $tournamentformdata['status']="1";
                            UserForm::create($tournamentformdata);
                        }
                    }
                }

                if($roleDetails->Privilleges){
                    foreach($roleDetails->Privilleges as $val){
                        $data['privillege_id']=$val->privillege_id;
                        $data['tournament_id']=NULL;
                        $data['user_id']=$user->id;
                        $data['type']="privillege";
                        UserAccess::create($data);
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
                $message="Admin already exist";
                return redirect()->route('admin')->with('deleteMessage',$message);
            }

        }
        
        return redirect()->route('admin')->with('message',$message);
    }

    public function destroy(Request $request,$id)
    {
        $user=User::find($id);
        $user->delete();
        UserAccess::where('user_id',$id)->delete();
        UserForm::where('user_id',$id)->delete();
        $message="Successfully Deleted the Record";
        return redirect()->route('admin')->with('deleteMessage',$message);
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
        return redirect()->route('admin')->with('message',$message);
    }
    public function tournaments(Request $request)
    {
        $input=$request->all();
        //print_r($input['category']);exit;
        $tournaments=Tournament::whereIn('category',$input['category'])->orderBy('category')->get();
        //print_r($tournaments);exit;
        return response()->json($tournaments);
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