<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Hash;

class Tournament extends Model
{
    protected $table = 'tournament_master';
    protected $fillable = [
        'title',
        'tournament_date',
        'category',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
    
}