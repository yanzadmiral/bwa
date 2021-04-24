<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $table = 'chapters';

    protected $fillable = [
        'name','course_id'
    ];

    public function lessons()
    {
        return $this->hasMany('App\Models\Lesson')->orderBy('id','DESC');
    }
}
