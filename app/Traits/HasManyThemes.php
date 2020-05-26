<?php

namespace App\Traits;

use App\Models\Theme;

trait HasManyThemes
{
    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
}
