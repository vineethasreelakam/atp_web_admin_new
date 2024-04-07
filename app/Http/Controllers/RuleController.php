<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\FormQuestionRule;



class RuleController extends Controller
{

    public function index() 
    {
        $pageLimit=20;
        $data['paginationRoute']="rule"; 
    	$data['listData'] = FormQuestionRule::orderBy('id','desc')->paginate($pageLimit);
    	//print_r($data['listData']);exit;
        return view('rule.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        $data['formData']=new FormQuestionRule;
        if(isset($input['id'])){
            //$data['formData']=Role::find($input['id']);
            $data['formData']=FormQuestionRule::find($input['id']);
            //Print_r($data['formData']);exit;
        }
        return view('rule.create',$data);
    }
    public function store(Request $request) 
    {
        $input=$request->all();

        if(isset($input['id'])){
            $rule=FormQuestionRule::find($input['id']);
            $rule->rule_code=$input['rule_code'];
            $rule->description=$input['description'];
            $rule->value_1=$input['value_1'];
            $rule->value_2=$input['value_2'];
            $rule->value_3=$input['value_3'];
            $rule->value_4=$input['value_4'];
            $rule->update();
            
            
            $message="Successfully Updated";
        }
        else{
            $rule=FormQuestionRule::create($input);
            
            $message="Successfully Saved";
        }
        
        return redirect()->route('rule')->with('message',$message);
    }

    public function destroy(Request $request,$id)
    {
        $rule=FormQuestionRule::find($id);
        $rule->delete();
        $message="Successfully Deleted the Record";
        return redirect()->route('rule')->with('deleteMessage',$message);
    }

     
}