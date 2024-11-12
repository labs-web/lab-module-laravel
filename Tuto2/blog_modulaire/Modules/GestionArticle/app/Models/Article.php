<?php

namespace Modules\GestionArticle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GestionArticle\Database\Factories\ArticleFactory;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): ArticleFactory
    // {
    //     // return ArticleFactory::new();
    // }
}
