<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerAdminCommission extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'partner_admin_commission';
}
