<?php

namespace App\Repositories\Subaddon;

use App\Repositories\Subaddon\SubaddonInterface;
use App\Models\Subaddon;
use Auth;

class SubaddonRepository implements SubaddonInterface
{
    private $subaddon;

    public function __construct(Subaddon $subaddon)
    {
        $this->subaddon = $subaddon;
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        $request["restaurant_id"] = session('selected_restro');
        return Subaddon::create($request);
    }

    /*
    * Function to remove category
    */
    public function remove($id)
    {
        return $this->subaddon::destroy($id);
    }

    /*
    * Function to change category status
    */
    public function changeStatus($id, $status)
    {
        return $this->subaddon::where('id', $id)->update(['status' => $status]);
    }

    /*
    * Function to update optional addon
    */
    public function update($request)
    {
        $addon = Subaddon::findOrFail($request->id);
        return $addon->update($request->all());
    }
}
