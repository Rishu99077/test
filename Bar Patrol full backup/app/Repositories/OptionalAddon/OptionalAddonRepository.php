<?php

namespace App\Repositories\OptionalAddon;

use App\Repositories\OptionalAddon\OptionalAddonInterface;
use App\Models\OptionalAddon;
use Auth;

class OptionalAddonRepository implements OptionalAddonInterface
{
    private $optionalAddon;

    public function __construct(OptionalAddon $optionalAddon)
    {
        $this->optionalAddon = $optionalAddon;
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        return OptionalAddon::create($request);
    }

    /*
    * Function to remove category
    */
    public function remove($id)
    {
        return $this->optionalAddon::destroy($id);
    }

    /*
    * Function to change category status
    */
    public function changeStatus($id, $status)
    {
        return $this->optionalAddon::where('id', $id)->update(['status' => $status]);
    }

    /*
    * Function to update optional addon
    */
    public function update($request)
    {
        $addon = OptionalAddon::findOrFail($request->id);
        return $addon->update($request->all());
    }

    /*
    * Function to update optional addon
    */
    public function updateData($id,$request)
    {   
        return $this->optionalAddon::where('id', $id)->update($request);
    }
}
