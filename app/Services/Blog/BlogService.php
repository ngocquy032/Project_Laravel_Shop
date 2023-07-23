<?php

namespace App\Services\Blog;

use App\Repositories\Blog\BlogRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\BaseService;

class BlogService extends BaseService implements BlogServiceInterface
{
    public $reponsitory;
    public function __construct(BlogRepositoryInterface $blogReponsitory)
    {
        $this->reponsitory = $blogReponsitory;
    }
    public function getLatestBlogs($limit = 3) {
        return $this->reponsitory->getLatestBlogs($limit);
    }
}
