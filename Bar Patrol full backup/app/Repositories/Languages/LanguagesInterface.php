<?php

namespace App\Repositories\Languages;

interface LanguagesInterface
{
    public function store($request);
    public function remove($id);
    public function changeStatus($id, $status);
    public function update($request);
}
