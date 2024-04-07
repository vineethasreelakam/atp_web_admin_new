<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FormQuestions extends Model
{
    use HasFactory;

    protected $table = 'form_questions';
    protected $primaryKey = 'id';

    public function form(): BelongsTo
    {
        return $this->belongsTo(Forms::class, 'form_id', 'id');
    }

    public function question_type(): BelongsTo
    {
        return $this->belongsTo(FormQuestionTypes::class, 'question_type_id', 'id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(FormQuestionSections::class, 'section_id', 'id');
    }

    public function question_values(): HasMany
    {
        return $this->hasMany(FormQuestionsValues::class, 'question_id', 'id');
    }

    public function question_rules(): HasOne
    {
        return $this->hasOne(FormQuestionRules::class, 'id', 'rule_id');
    }

}
