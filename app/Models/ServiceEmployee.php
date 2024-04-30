<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceEmployee extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'service_employees';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'shop_company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function shop_company()
    {
        return $this->belongsTo(ShopCompany::class, 'shop_company_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

}
