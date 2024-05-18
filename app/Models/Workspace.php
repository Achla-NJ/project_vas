<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $dates = ['agreement_date','effective_from','effective_to'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
