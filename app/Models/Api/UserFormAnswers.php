<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFormAnswers extends Model
{
    use HasFactory;

    protected $table = 'user_form_answers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_form_id',
        'user_id',
        'question_id',
        'answer',
    ];
}
