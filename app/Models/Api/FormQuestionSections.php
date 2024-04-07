<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormQuestionSections extends Model
{
    use HasFactory;

    protected $table = 'form_question_sections';
    protected $primaryKey = 'id';
}
