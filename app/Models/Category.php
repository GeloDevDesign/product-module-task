<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
