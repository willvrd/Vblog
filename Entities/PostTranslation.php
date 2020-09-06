<?php

namespace Modules\Vblog\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class PostTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $table = 'blog_post_translations';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'summary',
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
        return $this->meta_description ?? $this->summary;
    }


    public function getMetaTitleAttribute()
    {
        return $this->meta_title ?? $this->title;
    }

}
