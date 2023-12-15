<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReviewDescription extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'user_review_description';
}
