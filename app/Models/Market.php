<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS = ['ACTIVE', 'DISABLED', 'DISABLED_BY_EXCHANGE'];
}
