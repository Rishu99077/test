<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Pagedescriptions extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'page_descriptions';

}
