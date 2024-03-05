<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'checkout_address'
    ];

    /**
     * Get the user that owns the cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'user_id');
    }
}
