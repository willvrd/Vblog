<?php

namespace Modules\Vblog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTransformer extends JsonResource
{
    public function toArray($request)
    {

        $item = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'slug' => $this->when($this->slug, $this->slug),
            'description' => $this->when($this->description, $this->description),
            'metaTitle' => $this->when($this->meta_title, $this->meta_title),
            'metaDescription' => $this->when($this->meta_description, $this->meta_description),
            'metaKeywords' => $this->when($this->meta_keywords, $this->meta_keywords),
            'options' => $this->when($this->options, $this->options),
            'parentId' => $this->when($this->parent_id, $this->parent_id),
            'parent' => new CategoryTransformer($this->whenLoaded('parent')),
            'children' => CategoryTransformer::collection($this->whenLoaded('children')),
            'posts' => PostTransformer::collection($this->whenLoaded('posts')),
            'createdAt' => $this->when($this->created_at, $this->created_at->format('Y-m-d H:i:s')),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at->format('Y-m-d H:i:s'))
        ];

        $filter = json_decode($request->filter);

        if (isset($filter->allTranslations) && $filter->allTranslations) {

            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
              $item[$lang]['title'] = $this->hasTranslation($lang) ?
                $this->translate("$lang")['title'] : '';
              $item[$lang]['slug'] = $this->hasTranslation($lang) ?
                $this->translate("$lang")['slug'] : '';
              $item[$lang]['description'] = $this->hasTranslation($lang) ?
                $this->translate("$lang")['description'] ?? '' : '';
              $item[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
                $this->translate("$lang")['meta_title'] : '';
              $item[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
                $this->translate("$lang")['meta_description'] : '';
              $item[$lang]['metaKeywords'] = $this->hasTranslation($lang) ?
                $this->translate("$lang")['meta_keywords'] : '';
            }
        }

        return $item;

    }
}
