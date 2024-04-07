<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormQuestionTypes extends Model
{
    use HasFactory;

    protected $table = 'form_questions_types';
    protected $primaryKey = 'id';

    
}
