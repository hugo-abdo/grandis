<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function getReview()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->where('status', 'active')->orderBy('id', 'DESC');
    }
}
