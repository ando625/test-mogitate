<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 一括代入を許可するカラムを列挙
    protected $fillable = [
        'name',   // ← 今回エラーになった項目
        'price',
        'image',
        'description',
        'category_id',

    ];

    // Product → Season の多対多リレーション
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season', 'product_id', 'season_id');
    }
}
