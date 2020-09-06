<?php

namespace Modules\Vblog\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'blog_categories';

    protected $fillable = [
        'parent_id',
        'options'
    ];

    protected $translatedAttributes = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'options' => 'array'
    ];


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'blog_post_category');
    }

    public function getOptionsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }


}
