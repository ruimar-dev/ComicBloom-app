<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingList extends Model
{
    use HasFactory;

    protected $table = 'reading_list';

    protected $fillable = [
        'user_id', 'comic_id', 'title', 'description', 'thumbnail_url',
        'page_count', 'published_at', 'status', 'is_favorite',
        'characters', 'creators', 'marvel_url',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'characters'  => 'array',
        'creators'    => 'array',
        'published_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
