<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsMetaValue extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function cmsMeta(): BelongsTo
    {
        return $this->belongsTo(CmsMeta::class);
    }

    // direct children
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // recursive children
    // public function childrenRecursive(): HasMany
    // {
    //     return $this->children()->with('childrenRecursive');
    // }

    // parent
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
