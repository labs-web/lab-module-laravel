<?php

namespace App\Modules\GestionArticle\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Modules\GestionCategories\Models\Category', 'category_id');
    }
}