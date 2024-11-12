<?php

namespace Modules\PkgArticles\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];

    public function category()
    {
        return $this->belongsTo('Modules\PkgCategories\Models\Category', 'category_id');
    }
}