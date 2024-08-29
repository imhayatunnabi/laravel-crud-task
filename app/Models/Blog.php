<?php

namespace App\Models;

use App\Models\User;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($blog) {
            $blog->created_by_id = Auth::id();
            $blog->updated_by_id = Auth::id();
        });
        static::updating(function ($blog) {
            $blog->updated_by_id = Auth::id();
        });
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id', 'id');
    }
}
