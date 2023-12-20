<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts'; 
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'address',
        'description',
        'website'
    ];

}
