<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name','certificate','thumbnail','type','status','price','level','description','mentor_id'
    ];

    public function mentor()
    {
        return $this->belongsTo('App\Models\Mentor');
    }

    public function chapters()
    {
        return $this->belongsTo('App\Models\Chapter')->orderBy('id','ASC');
    }

    public function images()
    {
        return $this->belongsTo('App\Models\ImageCourse')->orderBy('id','DESC');

    }
}
