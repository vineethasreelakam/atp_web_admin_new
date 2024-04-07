<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class Form extends Model
{
    protected $table = 'form_master';
    protected $fillable = [
        'title',
        'image',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
    
}