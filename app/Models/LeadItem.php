<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lead_items';

    protected $fillable = [
        'lead_id',
        'item_name',
        'qty',
        'notes',
        'price',
        'subtotal',
        'status',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'subtotal'  => 'decimal:2',
    ];

    public function lead() {
        return $this->belongsTo(Lead::class);
    }
}
