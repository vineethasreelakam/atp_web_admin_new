<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class FormQuestionRule extends Model
{
    protected $table = 'form_question_rules';
    protected $fillable = [
        'rule_code',
        'description',
        'values_required',
        
    ];
   
    public function RuleValues(){
        return $this->hasmany('App\Models\FormRuleValue','rule_id','id');
    }
    
}