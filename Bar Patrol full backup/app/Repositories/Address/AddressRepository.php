<?php

namespace App\Repositories\Address;

use App\Repositories\Address\AddressInterface;
use App\Models\Address;

class AddressRepository implements AddressInterface
{
    private $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function get()
    {
        return $this->address::where('user_id', session('customer_id'))->get();
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        return $this->address::create($request);
    }

    public function update($data, $id)
    {
        return $this->address::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->address::where('id', $id)->delete();
    }
}
