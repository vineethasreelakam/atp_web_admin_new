<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

use DB;
use App\Models\UserAccess;
use App\Models\Role;
use App\Models\RoleAccess;
use App\Models\Privillege;

class RoleRepository 
{
   
   /*  public static function rolePrivilleges(){
        $data['roleAccessData']=Role::orderBy('id','desc')->get();
        //print_r($data['roleAccessData']['Privilleges']);exit;
        $roleAccess=[];
        foreach($data['roleAccessData'] as $val){
            $roleAccess=RoleAccess::where('role_id',$val->id)->get();
            $privilleges=[];
            foreach($roleAccess as $accessData){
                $privilleges[]=Privillege::where('id',$accessData->privillege_id)->first();
            }
            $roleAccess[]=$roleAccess;
        }
        $data['roleAccess']=$roleAccess;
        $data['privilleges']=$privilleges;
        return $data;
    } */

    


}