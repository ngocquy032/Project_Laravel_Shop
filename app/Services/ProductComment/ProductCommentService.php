<?php

namespace App\Services\ProductComment;

use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Repositories\ProductComment\BlogRepositoryInterface;
use App\Services\BaseService;

class ProductCommentService extends BaseService implements ProductCommentServiceInterface
{

    public $reponsitory;

    public function __construct(ProductCategoryRepositoryInterface $productCommentReponsitory)
    {
        $this->reponsitory = $productCommentReponsitory;
    }
}
