<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class FormQuestion extends Model
{
    protected $table = 'form_questions';
    protected $fillable = [
        'form_id',
        'question',
        'question_no',
        'question_type_id',
        'section_id',
        'rule_id',
    ];
   
    
    public function Values(){
        return $this->hasmany('App\Models\FormQuestionValue','question_id','id');
    }
    /* public function Role(){
        return $this->belongsTo('App\Models\Role', 'role_id','id');
    } */
    
}