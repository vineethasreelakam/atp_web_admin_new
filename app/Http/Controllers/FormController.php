<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Form;


class FormController extends Controller
{

    public function index() 
    {
        $pageLimit=20;
        $data['paginationRoute']="form"; 
    	$data['listData'] = Form::orderBy('id','desc')->paginate($pageLimit);
    	//print_r($data['listData']);exit;
        return view('form.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        $data['formData']=new Form;
        
        if(isset($input['id'])){
            //$data['formData']=Role::find($input['id']);
            $data['formData']=Form::find($input['id']);
            //Print_r($data['formData']);exit;
        }
        return view('form.create',$data);
    }
    public function store(Request $request) 
    {
        $input=$request->all();

        if($request->file('image')){
            $image=$request->file('image');
            $filename=$image->getClientOriginalName();
            $image->move('public/uploads/form',$filename);
            $input['image']=$filename;
        } 

        if(isset($input['id'])){
            $form=Form::find($input['id']);
            $form->title=$input['title'];
            $form->image=$input['image'];
            $form->description=$input['description'];
            $form->update();
            $message="Successfully Updated";
        }
        else{
            $role=Form::create($input);
            $message="Successfully Saved";
        }
        
        return redirect()->route('form')->with('message',$message);
    }

     public function imageDelete(Request $request,$id)
    {
        
        Form::where('id',$id)->update(['image'=>'']);
        $form=Form::find($id);
        $data['formData']=$form;
        $message="Successfully Deleted the image";
        return redirect()->route('form.create',['id'=>$id,'data'=>$data]);
    }
 
     
}