<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsMeta extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function cms(): BelongsTo
    {
        return $this->belongsTo(Cms::class);
    }

    function cmsMetaValues(): HasMany
    {
        return $this->hasMany(CmsMetaValue::class,'cms_meta_id');
    }
}
