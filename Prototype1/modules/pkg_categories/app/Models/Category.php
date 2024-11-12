<?php

namespace Modules\PkgCategories\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    // Relation One-to-Many : une catégorie a plusieurs articles
    public function articles()
    {
        return $this->hasMany('Modules\PkgArticles\Models\Article', 'category_id');
    }
}