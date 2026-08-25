<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\DocumentStatus;

class StatusHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'changed_by',
        'from_status',
        'to_status',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'from_status' => DocumentStatus::class,
        'to_status' => DocumentStatus::class,
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
