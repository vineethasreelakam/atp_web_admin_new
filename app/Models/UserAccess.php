<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class UserAccess extends Model
{
    protected $table = 'user_access';
    //protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'privillege_id',
        'tournament_id',
        'type',
        'status'
        
    ];
   
    public function Tournament(){
        return $this->belongsTo('App\Models\Tournament', 'id','tournament_id');
    }

    public function PrivillegeMaster(){
        return $this->hasmany('App\Models\Privillege', 'id','privillege_id');
    }
    
}