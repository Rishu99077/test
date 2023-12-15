<?php

namespace App\Repositories\Dashboard;

interface DashboardInterface
{
    public function update($request);
    public function store($request);
    public function remove($id);
    public function changeStatus($id, $status);
    public function makeItLive($status);
    public function deleteImage($id, $field);
    public function storeBranch($request);
}
