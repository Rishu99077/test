<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model
{
    protected $table = 'vendors';
    protected $fillable = [
        "vendor_name",
        "contact_name",
        "phone_number",
        "email",
        "status",
        "User_ID",
        "admin_id",
        "superadmin_id",
        "source",
    ];
}
