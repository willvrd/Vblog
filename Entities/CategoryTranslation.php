<?php

namespace Modules\Vblog\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $table = 'blog_category_translations';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->meta_description ?? substr(strip_tags($this->description??''),0,150);
    }


    public function getMetaTitleAttribute()
    {
        return $this->meta_title ?? $this->title;
    }

}
