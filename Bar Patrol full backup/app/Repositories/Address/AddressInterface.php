<?php

namespace App\Repositories\Address;

interface AddressInterface
{
    public function get();
    public function store($request);
    public function update($data, $id);
    public function delete($id);
}
