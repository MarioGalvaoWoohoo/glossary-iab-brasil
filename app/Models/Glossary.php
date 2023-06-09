<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glossary extends Model
{
    use HasFactory;

    protected $table = 'glossary';

    protected $fillable = [
        'metric',
        'topic',
        'subtopic',
        'content',
    ];

}
