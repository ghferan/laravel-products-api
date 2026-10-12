<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Prodect;

class Category extends Model
{
    protected $fillable = [
    'name',
    ];
    public function prodects(): HasMany
    {
        return $this->hasMany(Prodect::class);
    }
}
