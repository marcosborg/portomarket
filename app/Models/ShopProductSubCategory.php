<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProductSubCategory extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'shop_product_sub_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'shop_product_category_id',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function shopProductSubCategoriesShopProducts()
    {
        return $this->belongsToMany(ShopProduct::class);
    }

    public function shop_product_category()
    {
        return $this->belongsTo(ShopProductCategory::class, 'shop_product_category_id');
    }
}
