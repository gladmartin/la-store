<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $listCategory = [];

    static public function scopeRootCategory($query)
    {
        return $query->where('category_id', null);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function listParentAttribute($category = null)
    {
        $category = $category ?? $this;
        array_unshift($this->listCategory, $category);
        if (!$category->category_id) return $this->listCategory;
        $category = $category->parent()->first();
        $this->listParentAttribute($category);

        return $this->listCategory;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
