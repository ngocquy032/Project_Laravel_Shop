<?php

namespace App\Services\OrderDetail;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\BaseService;

class OrderDetailService extends BaseService implements OrderDetailServiceInterface
{
    public $reponsitory;
    public function __construct(OrderRepositoryInterface $orderReponsitory)
    {
        $this->reponsitory = $orderReponsitory;
    }
}
