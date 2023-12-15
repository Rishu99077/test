<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UserModel extends Model
{
    protected $table = 'users';
    protected $fillable = [
        "restaurant_name",
        "email",
        "password",
        "phone_no",
        "country",
        "state",
        "city",
        "user_role",
        "source",
    ];

}

