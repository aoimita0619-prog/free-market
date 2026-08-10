<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'price',
        'detail',
        'is_sold',
        'img',
        'condition_id',
        'user_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }

    public function condition()
   {
    return $this->belongsTo(Condition::class);
   }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

     public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
        $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

}
