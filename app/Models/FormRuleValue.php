<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class FormRuleValue extends Model
{
    protected $table = 'form_rules_values';
    protected $fillable = [
        'question_id',
        'rule_id',
        'rule_value_no',
        'rule_value',
        'status',
        
    ];
   
   
    
}