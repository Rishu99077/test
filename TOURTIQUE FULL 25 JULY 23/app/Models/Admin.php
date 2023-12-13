<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use Exception;
class Admin extends Model{
    use HasFactory;
    protected $table = 'admin';
    
    
    

    public static function send_mail($data)
    {
        $sent = '';
        try {
            $sent = Mail::send($data['page'], $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['subject']);
            });
        } catch (Exception $e) {
            $sent = false;
        }
        return $sent;
    }
}