<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletHistory extends Model
{
    use HasFactory;
    protected $table = "user_wallet_history";
    protected $guarded = [];
}
