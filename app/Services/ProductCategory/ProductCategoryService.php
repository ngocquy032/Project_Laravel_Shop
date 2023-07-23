<?php

namespace App\Services\ProductCategory;

use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Services\BaseService;

class ProductCategoryService extends BaseService implements ProductCategoryServiceInterface
{
    public $reponsitory;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryReponsitory)
    {
        $this->reponsitory = $productCategoryReponsitory;
    }

}
