<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{
    MorphTo,
    BelongsTo,
};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text'
    ];

    /**
     * Get the topic that owns the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get the parent messageable model (user or admin).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function messageable(): MorphTo
    {
        return $this->morphTo();
    }
}
