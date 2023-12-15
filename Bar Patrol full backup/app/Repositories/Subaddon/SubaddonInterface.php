<?php

namespace App\Repositories\Subaddon;

interface SubaddonInterface
{
    public function store($request);
    public function remove($id);
    public function changeStatus($id, $status);
    public function update($request);
}
