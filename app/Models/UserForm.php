<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class UserForm extends Model
{
    protected $table = 'user_form';
    protected $fillable = [
        'id',
        'user_id',
        'form_id',
        'tournament_id',
        'status',
        
    ];
   
    public function Formmaster(){
        return $this->belongsTo('App\Models\User', 'form_id','id');
    }
    
}