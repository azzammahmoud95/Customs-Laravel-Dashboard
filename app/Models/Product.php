<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;
    protected $table = 'products';

    protected $fillable = ['name', 'HScode', 'description', 'image', 'note', 'category_id'];

    public function taxes()
    {
        return $this->belongsToMany(Tax::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
