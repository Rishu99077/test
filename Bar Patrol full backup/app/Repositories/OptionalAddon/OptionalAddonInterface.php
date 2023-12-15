<?php

namespace App\Repositories\OptionalAddon;

interface OptionalAddonInterface
{
    public function store($request);
    public function remove($id);
    public function changeStatus($id, $status);
    public function update($request);
}
