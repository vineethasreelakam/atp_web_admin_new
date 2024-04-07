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


class TournamentController extends Controller
{

    /* public function index() 
    {
        $pageLimit=20;
        $data['paginationRoute']="tournament"; 
    	$data['listData'] = Tournament::paginate($pageLimit);
        return view('tournament.index',$data);
    }
 */
    public function index(Request $request) 
    {
        $pageLimit=20;
        $data['paginationRoute']="tournament"; 
        $input=$request->all();
        $year=date('Y');
        if(isset($input['year'])){
            $year=$input['year'];
        }
    	$data['listData'] = Tournament::whereYear('tournament_date', '=', $year)->paginate($pageLimit);
        if(count($data['listData'])<1){
            //return redirect()->back()->with('message', $message);
            $year=2024;
            $data['listData'] = Tournament::whereYear('tournament_date', '=', $year)->paginate($pageLimit);
        }
        return view('tournament.index',$data);
    }
    public function create(Request $request) 
    {
        $input=$request->all();
        $data['formData']=new User;
        if(isset($input['id'])){
            //$data['formData']=Role::find($input['id']);
            $data['formData']=Tournament::find($input['id']);
        }
        return view('tournament.create',$data);
    }
    public function store(Request $request) 
    {
        $input=$request->all();
        //print_r($input);exit;
        if(isset($input['id'])){
            $tournament=Tournament::find($input['id']);
            $tournament->title=$input['title'];
            $tournament->tournament_date=date('Y-m-d',strtotime($input['tournament_date']));
            $tournament->category=$input['category'];
            $tournament->description=$input['description'];
            $tournament->update();

            $message="Successfully Updated";
        }
        else{
            $input['tournament_date']=date('Y-m-d',strtotime($input['tournament_date']));
            $tournament=Tournament::create($input);
            $message="Successfully Saved";
        }
        
        return redirect()->route('tournament')->with('message',$message);
    }

    public function destroy(Request $request,$id)
    {
        $tournament=Tournament::find($id);
        $tournament->delete();
        $message="Successfully Deleted the Record";
        return redirect()->route('tournament')->with('deleteMessage',$message);
    }

    public function changeStatus(Request $request,$id)
    {
        $tournament=Tournament::find($id);
        if($tournament->status==1){
            $tournament->status='0';
        }
        else{
            $tournament->status='1';
        }
        $tournament->save();
        $message="Successfully Changed Status";
        return redirect()->route('tournament')->with('message',$message);
    }

    
     
}