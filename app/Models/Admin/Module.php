<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Content;
use App\Models\Admin\Course;

class Module extends Model
{
    protected $fillable = ['title','course_id'];
    
    public function course(){
        return $this->belongsTo( Course::class, 'course_id');
    }
    public function contents(){
        return $this->hasMany( Content::class);
    }
}
