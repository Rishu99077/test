<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UserModel extends Model{
    protected $table = 'users';
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "phone_no",
        "country",
        "state",
        "city",
        "password",
        "user_role",
        "profile_image",
    ];
}

