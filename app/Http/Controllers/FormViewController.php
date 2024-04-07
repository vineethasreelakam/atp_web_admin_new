<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Tournament;
use App\Models\UserForm;
use App\Models\User;


class FormViewController extends Controller
{

    public function index(Request $request) 
    {
        $pageLimit=20;
        $data['paginationRoute']="formview"; 
        $input=$request->all();
        $year=date('Y');
        if(isset($input['year'])){
            $year=$input['year'];
        }
        $sql=Tournament::query();
        
        if(isset($input['search'])){
            $search=$input['search'];
            if(isset($input['selectedYear'])){
                $selectedYear=$input['selectedYear'];
            }
            $sql=$sql->where('title','LIKE','%'.$search.'%')->whereYear('tournament_date', '=', $selectedYear); 
        }
        else{
            $sql=$sql->whereYear('tournament_date', '=', $year);
        }
        $sql=$sql->paginate($pageLimit);
        $data['listData']=$sql;

    	//$data['listData'] = Tournament::whereYear('created_at', '=', $year)->paginate($pageLimit);
    	//print_r($data['listData']);exit;
        //$data['NoDataMessage']='';
        if(count($data['listData'])<1){
            //$data['NoDataMessage']="Data not found in ".$year;
            $year=2024;
            $data['listData'] = Tournament::whereYear('tournament_date', '=', $year)->paginate($pageLimit);
        }
        //print_r($data);exit;
        return view('form.formView.index',$data);
    }

    public function formslist(Request $request){
        $pageLimit=20;
        $data['paginationRoute']="formview.list"; 
        $input=$request->all();
        
        $tournamentId=$input['id'];
        $user=User::join('user_form','users.id','user_form.user_id')->where(function($query) use ($tournamentId){  
                                $query->where('user_form.tournament_id',$tournamentId);
                            })
                            ->select('users.id as userId','users.name','users.admin','user_form.*')
                            ->groupBy('users.id')
                            ->paginate($pageLimit);
        $data['listData'] = $user;
        //print_r($data['listData']);exit;
        
        return view('form.formView.formslist',$data);
    }

    public function formsDetails(Request $request){
         
        $input=$request->all();
        
        $completedUserForm=UserForm::join('form_master','user_form.form_id','form_master.id')
                                    ->where('user_form.user_id',$input['userId'])
                                    ->where('user_form.tournament_id',$input['tournamentId'])
                                    ->where('user_form.status','completed')
                                    ->select('form_master.id as formId','form_master.title','form_master.image','user_form.*')
                                    ->get();

        $reviewedUserForm=UserForm::join('form_master','user_form.form_id','form_master.id')
                                    ->where('user_form.user_id',$input['userId'])
                                    ->where('user_form.tournament_id',$input['tournamentId'])
                                    ->where('user_form.status','reviewed')
                                    ->select('form_master.id as formId','form_master.title','form_master.image','user_form.*')
                                    ->get();

        $data['completedListData'] =$completedUserForm;
        $data['reviewedListData'] =$reviewedUserForm;

        $data['userId'] = $input['userId'];
        $data['tournamentId']=$input['tournamentId'];
        //print_r($data['completedListData']);exit;
        
        return view('form.formView.formdetails',$data);
    }
     
}