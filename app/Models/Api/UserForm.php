<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserForm extends Model
{
    use HasFactory;

    protected $table = 'user_form';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'form_id',
        'status',
        'tournament_id',
        'description',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Forms::class, 'form_id', 'id');
    }

}
