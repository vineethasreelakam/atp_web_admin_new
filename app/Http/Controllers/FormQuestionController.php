<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Role;
use App\Models\Form;
use App\Models\FormQuestion;
use App\Models\FormQuestionSection;
use App\Models\FormQuestionsType;
use App\Models\FormQuestionRule;
use App\Models\FormQuestionValue;
use App\Models\FormRuleValue;


class FormQuestionController extends Controller
{

    public function index(Request $request) 
    {
        $pageLimit=20;
        $data['paginationRoute']="formQuestion"; 
        $data['$querystring']=['formId'=>7];
    	$data['listData'] = FormQuestion::leftJoin('form_rules_values','form_rules_values.question_id','form_questions.id')
                                            ->select('form_questions.*','form_rules_values.rule_id')
                                            ->where('form_questions.form_id',$request->formId)->orderBy('form_questions.question_no')->paginate($pageLimit);
    	//print_r($data['listData']);exit;
        $data['formId']=$request->formId;
        return view('form.question.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        //print_r($input);exit;
        $data['formData']=new FormQuestion;
        $data['questionSection']=FormQuestionSection::where('form_id',$input['formId'])->get();
        $data['questionType']=FormQuestionsType::get();
        $ruleId=isset($input['rule_id']) ? $input['rule_id'] : 0;
        $data['questionRule']=FormQuestionRule::leftJoin('form_rules_values',function($join)use($ruleId){
                                $join->on('form_question_rules.id','=','form_rules_values.rule_id')
                                ->on('form_rules_values.rule_id','=',DB::raw($ruleId));
                                })
                                ->select('form_rules_values.*','form_question_rules.id as ruleId','form_question_rules.rule_code','form_question_rules.values_required')
                                ->get();

        //print_r($data['questionRule']);exit;
       /*  $questionRule=FormQuestionRule::query();
        $questionRule=$questionRule->FormQuestionRule::with('RuleValues');
        if(isset($input['id']) && isset($input['ruleId'])){
            $questionRule=$questionRule->where('id',$input['ruleId']);
        } */

        if(isset($input['id'])){
            $data['formData']=FormQuestion::with('Values')->find($input['id']);
            $data['formRuleValues']=FormRuleValue::where('rule_id',$ruleId)->where('question_id',$input['id'])->get();
           // $data['questionRule']=FormQuestionRule::with('RuleValues')->where('id',$input['ruleId'])->first();
            //var_dump($data['questionRule']->flatMap->RuleValues);exit;
        }
        return view('form.question.create',$data);
    }
    public function store(Request $request) 
    {
        $input=$request->all();
        //print_r($input['rule_id']);exit;
        if(isset($input['id'])){
            $formquestion=FormQuestion::find($input['id']);

            $formquestion->form_id=$input['formId'];
            $formquestion->question=$input['question'];
            $formquestion->question_no=$input['question_no'];
            $formquestion->section_id=$input['section_id'];
            $formquestion->question_type_id=$input['question_type_id'];
            $formquestion->rule_id=$input['rule_id'];
            $formquestion->save();
            FormQuestionValue::where('question_id',$formquestion->id)->delete();
            FormRuleValue::where('question_id',$formquestion->id)->delete();

            if(isset($input['question_type_value'])){
                foreach($input['question_type_value'] as $key=>$questionTypeVal){
                    if($questionTypeVal!=''){
                        $questionTypeData=[];
                        if(isset($input['question_type_value_id'])){
                            $questionTypeData['id']=$input['question_type_value_id'][$key];
                        }
                        $questionTypeData['question_id']=$formquestion->id;
                        $questionTypeData['option_value']=$questionTypeVal;
                        FormQuestionValue::create($questionTypeData);
                    }
                }
            }

            if(isset($input['rule_value'])){
                foreach($input['rule_value'] as $key=>$ruleVal){
                    if($ruleVal!=''){
                        $questionruleData=[];
                        if(isset($input['question_rule_value_id'])){
                            $questionruleData['id']=$input['question_rule_value_id'][$key];
                        }
                        $questionruleData['question_id']=$formquestion->id;
                        $questionruleData['rule_id']=$input['rule_id'];
                        $questionruleData['rule_value_no']=$input['rule_value_no'][$key];
                        $questionruleData['rule_value']=$ruleVal;
                        FormRuleValue::create($questionruleData);
                    }
                }
            }
           
            $message="Successfully Updated";
        }
        else{
            $input['form_id']=$input['formId'];
            $formquestion=FormQuestion::create($input);
            if(isset($input['question_type_value'])){
                foreach($input['question_type_value'] as $questionTypeVal){
                    if($questionTypeVal!=''){
                        $questionTypeData['question_id']=$formquestion->id;
                        $questionTypeData['option_value']=$questionTypeVal;
                        FormQuestionValue::create($questionTypeData);
                    }
                }
            }

            if(isset($input['rule_value']) && isset($input['rule_value_no'])){
                foreach($input['rule_value'] as $key=>$questionRuleVal){
                    if($questionRuleVal!=''){
                        $ruleData['question_id']=$formquestion->id;
                        $ruleData['rule_id']=$input['rule_id'];
                        $ruleData['rule_value_no']=$input['rule_value_no'][$key];
                        $ruleData['rule_value']=$questionRuleVal;
                        FormRuleValue::create($ruleData);
                    }
                }
            }
            $message="Successfully Saved";
        }
        
        return redirect()->route('formQuestion',['formId'=>$input['formId']])->with('message',$message);
    }

    public function destroy(Request $request)
    {
        $input=$request->all();
        $formquestion=FormQuestionSection::find($input['id']);
        $formquestion->delete();
        $message="Successfully Deleted the Record";
        return redirect()->route('formQuestion',['formId'=>$input['formId']])->with('deleteMessage',$message);
    }

     
}