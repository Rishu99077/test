<?php

namespace App\Repositories\Languages;

use App\Repositories\Languages\LanguagesInterface;
use App\Models\Languages;
use Auth;

class LanguagesRepository implements LanguagesInterface
{
    private $languages;

    public function __construct(Languages $languages)
    {
        $this->languages = $languages;
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        $request["restaurant_id"] = session('selected_restro');
        return Languages::create($request);
    }

    /*
    * Function to remove category
    */
    public function remove($id)
    {
        return $this->languages::destroy($id);
    }

    /*
    * Function to change category status
    */
    public function changeStatus($id, $status)
    {
        return $this->languages::where('id', $id)->update(['status' => $status]);
    }

    /*
    * Function to update optional addon
    */
    public function update($request)
    {
        $addon = Languages::findOrFail($request->id);
        return $addon->update($request->all());
    }
}
