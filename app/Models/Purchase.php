<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'purchases';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_RADIO = [
        'product' => 'Produto',
        'service' => 'Serviço',
    ];

    protected $fillable = [
        'type',
        'relationship',
        'name',
        'price',
        'vat',
        'status',
        'user_id',
        'total',
        'qty',
        'cart',
        'address',
        'method',
        'payed',
        'internal',
        'id_payment',
        'delivery',
        'delivery_value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'relationship', 'id');
    }
}