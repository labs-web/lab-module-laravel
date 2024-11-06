<?php

namespace App\Modules\GestionCategories\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    // Relation One-to-Many : une catégorie a plusieurs articles
    public function articles()
    {
        return $this->hasMany('App\Modules\GestionArticle\Models\Article', 'category_id');
    }
}