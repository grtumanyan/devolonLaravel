<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'parent'];

    public function children(){
        return $this->hasMany( 'App\Company', 'parent', 'id' );
    }

    public function parent(){
        return $this->hasOne( 'App\Company', 'id', 'parent' );
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren', 'stations');
    }

    public function stations()
    {
        return $this->hasMany('App\Station','company');
    }
}
