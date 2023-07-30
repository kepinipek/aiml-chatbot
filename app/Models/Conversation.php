<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\ConversationProperty;
use App\Models\Turn;
use App\Services\AimlStrService;

class Conversation extends Model
{
    use SoftDeletes;
    use HasSlug;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'slug',
        'user_id',
    ];

    public function conversationProperties()
    {
        return $this->hasMany(ConversationProperty::class);
    }

    public function missingCategories()
    {
        return $this->hasMany(MissingQuestion::class);
    }

    public function turns()
    {
        return $this->hasMany(Turn::class);
    }

    public function currentConversationTurn()
    {
        return $this->turns()->latest('turns.id')->first();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function () {
                return Str::uuid()->toString();
            })
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function isFirstTurn()
    {
        return !$this->turns()->exists();
    }

    public function getInput($index = 0)
    {
        return $this->turns()->where('source', 'human')->latest('id')->skip($index)->first()->input;
    }

    public function getTopic($index = 0)
    {
        return $this->conversationProperties()->where('name', 'topic')->latest('conversation_properties.id')->first();
    }

    public function getThat($index = 1)
    {
        $lastSource = $this->currentConversationTurn()->source;

        if ($lastSource=='human') {
            $that = $this->turns()->where('source', 'human')->latest('id')->skip($index)->first();
        } else {
            $that = $this->turns()->where('source', '!=', 'multiple')->latest('id')->skip($index)->first();
        }

        return $that;
    }

    public function getVars()
    {
        return $this->conversationProperties();
    }

    public function getVar($name, $index = 0)
    {
        $ret = $this->conversationProperties()->where('name', $name)->latest('conversation_properties.id')->skip($index)->first();
        return $ret != '' ? $ret->value : '';
    }

    public function setVar($name, $value)
    {
        ConversationProperty::Create([
            'conversation_id' => $this->id,
            'name' => $name,
            'value' => $value,
        ]);
    }

    public function delVar($name)
    {
        $this->conversationProperties()->where('name', $name)->delete();
    }

    public function isHumanTurn()
    {
        return ($this->currentConversationTurn()->source === 'human');
    }

    public function setOutputValue($value)
    {
        $this->currentConversationTurn()->update(['output' => $value]);
    }
}
