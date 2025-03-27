<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'foreign_id'];

    // A category can have multiple subcategories
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'foreign_id', 'id');
    }

    // A subcategory belongs to a parent category
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'foreign_id', 'id');
    }
}

