<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Role;
use App\Models\Form;
use App\Models\FormQuestionSection;


class FormQuestionSectionController extends Controller
{

    public function index(Request $request) 
    {
        $pageLimit=20;
        $data['paginationRoute']="formQuestionSection"; 
    	$data['listData'] = FormQuestionSection::where('form_id',$request->formId)->orderBy('id','desc')->paginate($pageLimit);
    	//print_r($data['listData']);exit;
        $data['formId']=$request->formId;
        return view('form.section.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        $data['formData']=new FormQuestionSection;
        if(isset($input['id'])){
            //$data['formData']=Role::find($input['id']);
            $data['formData']=FormQuestionSection::find($input['id']);
            //Print_r($data['formData']);exit;
        }
        return view('form.section.create',$data);
    }
    public function store(Request $request) 
    {
        $input=$request->all();
        //print_r($input);exit;
        if(isset($input['id'])){
            $formquestionsection=FormQuestionSection::find($input['id']);
            $formquestionsection->title=$input['title'];
            $formquestionsection->form_id=$input['formId'];
            $formquestionsection->section_type=$input['section_type'];
            $formquestionsection->update();
            
            $message="Successfully Updated";
        }
        else{
            $input['form_id']=$input['formId'];
            $formquestionsection=FormQuestionSection::create($input);
            
            $message="Successfully Saved";
        }
        
        return redirect()->route('formQuestionSection',['formId'=>$input['formId']])->with('message',$message);
    }

    public function destroy(Request $request)
    {
        $input=$request->all();
        $formquestionsection=FormQuestionSection::find($input['id']);
        $formquestionsection->delete();
        $message="Successfully Deleted the Record";
        return redirect()->route('formQuestionSection',['formId'=>$input['formId']])->with('deleteMessage',$message);
    }

     
}