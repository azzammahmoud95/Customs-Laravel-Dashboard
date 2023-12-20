<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $table = 'taxes';
    protected $fillable = [
        'name',
        'rate',
        'image'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    // public function hasProducts()
    // {
    //     return $this->products()->exists(); this function to check if the relation is working with it
    // }
    
}
