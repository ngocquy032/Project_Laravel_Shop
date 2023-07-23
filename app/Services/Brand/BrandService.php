<?php

namespace App\Services\Brand;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Services\BaseService;

class BrandService extends BaseService implements BrandServiceInterface

{
    public $reponsitory;

    public function __construct(BrandRepositoryInterface $brandReponsitory)
    {
        $this->reponsitory = $brandReponsitory;
    }

}
