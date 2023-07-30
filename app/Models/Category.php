<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

   	protected $dates = ['deleted_at'];

    protected $fillable = [
        'pattern',
        'topic',
        'that',
        'template'
    ];

    public function scopeSearch($query, array $arrSearch)
    {
        $query->when($arrSearch['q'] ?? false, function($query, $search) {
            return $query->where('pattern', 'like', '%' . $search . '%')
                        ->orWhere('template', 'like', '%' . $search . '%');
        });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('pattern')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
