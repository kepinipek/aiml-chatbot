<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class MissingQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'input',
        'status',
        'conversation_id',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function scopeSearch($query, array $arrSearch)
    {
        $query->when($arrSearch['q'] ?? false, function($query, $search) {
            return $query->where('pattern', 'like', '%' . $search . '%');
        });
    }

    public const STATUS = array(0 => 'Pertanyaan Baru', 1 => 'Sudah Ditambahkan Ke Pengetahuan');

    public function statusName()
    {
        return Arr::get(self::STATUS, $this->status, 'Not Assign');
    }
}
