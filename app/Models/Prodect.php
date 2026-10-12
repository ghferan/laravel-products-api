<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;

class Prodect extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
