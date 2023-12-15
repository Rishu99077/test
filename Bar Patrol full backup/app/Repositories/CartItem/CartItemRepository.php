<?php

namespace App\Repositories\CartItem;

use App\Repositories\CartItem\CartItemInterface;
use App\Models\CartItems;

class CartItemRepository implements CartItemInterface
{
    private $cartItem;

    public function __construct(CartItems $cartItem)
    {
        $this->cartItem = $cartItem;
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        return $this->cartItem::create($request);
    }

    public function get($request)
    {
        return $this->cartItem::where($request)->get();
    }
}
