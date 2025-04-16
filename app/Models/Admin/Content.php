<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['title','type','category','module_id'];

    public function module(){
        return $this->belongsTo( Module::class, 'module_id' );
    }
}
