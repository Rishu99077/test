<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CustomersModel extends Model{
    protected $table = 'customers';
    protected $fillable = [
        "firstname",
        "surname",
        "nick_name",
        "country",
        "state",
        "city",
        "address",
        "zip_code",
        "house_number",
        "phone_number",
        "email",
        "password",
        "role",
        "added_by",
        "status",
        "files",
    ];
}

