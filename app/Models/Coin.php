<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS = ['DISABLED', 'ACTIVE', 'DISABLED_BY_EXCHANGE'];
}
