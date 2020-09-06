<?php

namespace Modules\Vblog\Entities;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use Modules\Vblog\Presenters\PostPresenter;

class Post extends Model implements TranslatableContract
{

    use Translatable, PresentableTrait;

    protected $table = 'blog_posts';
    protected $presenter = PostPresenter::class;

    protected $fillable = [
        'user_id',
        'options'
    ];

    protected $translatedAttributes = [
        'title',
        'slug',
        'description',
        'summary',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo("Modules\User\Entities\User");
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_post_category');
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
