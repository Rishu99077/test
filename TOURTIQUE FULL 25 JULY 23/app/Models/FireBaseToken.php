<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireBaseToken extends Model
{
    use HasFactory;
    protected $table = 'firebase_tokens';
}