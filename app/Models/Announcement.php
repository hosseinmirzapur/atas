<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    const TYPE = ['WHATS_NEW', 'IMPORTANT', 'SERVICES'];
}
