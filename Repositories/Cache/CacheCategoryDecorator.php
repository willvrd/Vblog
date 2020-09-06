<?php

namespace Modules\Vblog\Repositories\Cache;

use Modules\Vblog\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'vblog.categories';
        $this->repository = $category;
    }


}
