<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'name',
        'description',
        'settings',
    ];
}
