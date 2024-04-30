<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanItem extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'plan_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_RADIO = [
        '1' => 'Included',
        '0' => 'Not included',
    ];

    protected $fillable = [
        'text',
        'plan_id',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}