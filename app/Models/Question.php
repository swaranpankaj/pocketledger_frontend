<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Options;
use App\Models\UserAnswer;

class Question extends Model
{
    use HasFactory;

    protected $table = 'onboarding_question'; // Table name

    // Mass assignable attributes
    protected $fillable = [
        'question',
        'image',
        'input_type',
        'description',
        'title',
        'status',
        'type',
    ];


    public static function insertQuestion($data)
    {
        return self::create($data);
    }


    public function options(){
        return $this->hasMany(Options::class, 'question_id', 'id');
    }

    public function userAnswers(){
        return $this->hasOne(UserAnswer::class, 'question_id', 'id');
    }
}
