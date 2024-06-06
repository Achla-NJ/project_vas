<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noc extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $dates = ['noc_date'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
