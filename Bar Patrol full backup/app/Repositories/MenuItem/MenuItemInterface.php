<?php

namespace App\Repositories\MenuItem;

interface MenuItemInterface
{
    public function store($request);
    public function remove($id);
    public function changeStatus($id, $status);
    public function update($request);
}
