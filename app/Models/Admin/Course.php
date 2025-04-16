<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Module;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title','level','price','featured_image'];

    public function modules(){
        return $this->hasMany( Module::class );
    }
}
