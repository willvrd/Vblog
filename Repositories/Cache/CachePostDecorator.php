<?php

namespace Modules\Vblog\Repositories\Cache;

use Modules\Vblog\Repositories\PostRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePostDecorator extends BaseCacheDecorator implements PostRepository
{
    public function __construct(PostRepository $post)
    {
        parent::__construct();
        $this->entityName = 'vblog.posts';
        $this->repository = $post;
    }


}
