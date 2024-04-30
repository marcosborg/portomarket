<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShopProduct extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'shop_products';

    protected $appends = [
        'photos',
        'attachment',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'reference',
        'description',
        'price',
        'sales_price',
        'sales_label',
        'tax_id',
        'youtube',
        'attachment_name',
        'state',
        'position',
        'stock',
        'shipping_cost',
        'weight',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function shopProductShopProductVariations()
    {
        return $this->hasMany(ShopProductVariation::class, 'shop_product_id', 'id');
    }

    public function getPhotosAttribute()
    {
        $files = $this->getMedia('photos');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function shop_product_categories()
    {
        return $this->belongsToMany(ShopProductCategory::class);
    }

    public function tax()
    {
        return $this->belongsTo(ShopTax::class, 'tax_id');
    }

    public function shop_product_sub_categories()
    {
        return $this->belongsToMany(ShopProductSubCategory::class);
    }

    public function getAttachmentAttribute()
    {
        return $this->getMedia('attachment')->last();
    }

    public function shop_product_features()
    {
        return $this->hasMany(ShopProductFeature::class);
    }

    public function shop_product_variations()
    {
        return $this->hasMany(ShopProductVariation::class);
    }


}