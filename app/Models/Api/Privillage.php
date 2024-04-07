<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privillage extends Model
{
    use HasFactory;

    protected $table = 'privillege_master';
    protected $primaryKey = 'id';

}
