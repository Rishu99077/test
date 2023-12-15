<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function update($request, $where);
}
