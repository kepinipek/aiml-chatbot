<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConversationProperty extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'conversation_id',
        'slug',
        'name',
        'value',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
