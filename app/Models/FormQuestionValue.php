<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class FormQuestionValue extends Model
{
    protected $table = 'form_questions_values';
    protected $fillable = [
        'id',
        'question_id',
        'option_value',
    ];
   
   
    
}