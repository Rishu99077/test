<?php

namespace App\Repositories\CartItem;

interface CartItemInterface
{
    public function store($request);
    public function get($request);
}
