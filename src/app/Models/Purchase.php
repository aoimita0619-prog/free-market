<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'method',
        'post_code',
        'address',
        'building',
    ];

    public function item()
{
    return $this->belongsTo(Item::class);
}
}

