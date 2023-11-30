<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Admin extends Model
{
    use HasFactory;
    const STATUS = ['ACTIVATED', 'DISABLED'];

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->status == 'DISABLED';
    }

    /**
     * @return MorphMany
     */
    public function gMessages(): MorphMany
    {
        return $this->morphMany(GMessage::class, 'owner');
    }
}
