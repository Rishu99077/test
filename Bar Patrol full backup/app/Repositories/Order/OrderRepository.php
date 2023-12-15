<?php

namespace App\Repositories\Order;

use App\Repositories\Order\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /*
    * Function to store new order
    */
    public function store($request)
    {
        return $this->order::create($request);
    }
}
