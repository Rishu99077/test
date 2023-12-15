<?php

namespace App\Repositories\MenuCategory;

interface MenuCategoryInterface
{
    public function store($request);
    public function remove($id);
    public function changeStatus($id, $status);
    public function update($request);
    public function deleteImage($id, $field);
    public function getAddons($category_id);
}
