<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileMoneyAccount extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'number', 'type_id', 'is_active'];
}
