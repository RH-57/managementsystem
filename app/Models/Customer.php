<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'company',
        'email',
        'phone',
        'address',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->code)) {
                $last = self::orderBy('id', 'desc')->first();
                $number = $last ? $last->id + 1 : 1;
                $model->code = 'CU' . str_pad($number, 3, '0', STR_PAD_LEFT);
                // Contoh: CU0001, CU0002, dst
            }
        });
    }
}
