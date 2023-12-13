<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactUsModel extends Model{
    protected $table = 'contact_us';
    protected $fillable = [
        "topic",
        "email",
        "files",
        "message",
        "customer_id",
    ];
}