<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;
use Mail;

class User extends Model
{
    use HasFactory;

    public static function send_mail($data)
    {
        $admin = Settings::where(['meta_title' => "email"])->first();
        $sent = Mail::send($data['page'], $data, function ($message) use ($data, $admin) {
            $message->to($data['email'])->subject($data['subject'])->from($admin->content);
        });
    }
}
