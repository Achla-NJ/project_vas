<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded =[];
    protected $dates = [ 'deleted_at' , 'due_date'];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
