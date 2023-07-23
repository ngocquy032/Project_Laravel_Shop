<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\BaseService;

class OrderService extends BaseService implements OrderServiceInterface
{
    public $reponsitory;
    public function __construct(OrderRepositoryInterface $orderReponsitory)
    {
        $this->reponsitory = $orderReponsitory;
    }


    public function getOrderByUserId($userId)
    {
        return $this->reponsitory->getOrderByUserId($userId);
    }
}
