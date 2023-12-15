<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model{
    use HasFactory;
    public $timestamps = true;
    protected $table = "contact_us";

}