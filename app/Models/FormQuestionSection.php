<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class FormQuestionSection extends Model
{
    protected $table = 'form_question_sections';
    protected $fillable = [
        'form_id',
        'title',
        'section_type',
        
    ];
   
   
    
}