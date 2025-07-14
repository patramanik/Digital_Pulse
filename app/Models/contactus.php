<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contactus extends Model
{
    protected $table = 'contactus';

    protected $fillable =[
        'full_name',
        'email',
        'message',
    ];
}
