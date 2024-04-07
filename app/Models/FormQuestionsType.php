<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class FormQuestionsType extends Model
{
    protected $table = 'form_questions_types';
    protected $fillable = [
        'question_type',
    ];
   
   
    
}