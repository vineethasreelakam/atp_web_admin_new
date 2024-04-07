<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFormEditedUsers extends Model
{
    use HasFactory;

    protected $table = 'user_form_edited_users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_form_id',
        'edited_by',
        'date',
    ];
}
