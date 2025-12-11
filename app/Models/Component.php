<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Unit;

class Component extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'code',
        'name',
        'unit_id',
        'price'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Jika code belum diisi, generate otomatis
            if (empty($model->code)) {
                $last = self::orderBy('id', 'desc')->first();
                $number = $last ? $last->id + 1 : 1;
                $model->code = 'C' . str_pad($number, 2, '0', STR_PAD_LEFT);
            }
        });
    }

}
