<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class LeadFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'filename',
        'original_name',
        'path',
        'disk',
        'mime_type',
        'size',
        'type',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    // Generate full URL untuk frontend
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($file) {
            if ($file->path && $file->disk) {
                Storage::disk($file->disk)->delete($file->path);
            }
        });
    }
}
