<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model{
    protected $table = 'contact_details';
    protected $fillable = [
        "first_name",
        "family_name",
        "email",
        "phone",
        "topic",
        "message",
        "image",
        "status",
    ];
}