<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $dates = ['due_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspaces()
    {
        return $this->hasMany(Workspace::class);
    }

    public function nocs()
    {
        return $this->hasMany(Noc::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
