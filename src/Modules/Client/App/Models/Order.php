<?php

namespace Modules\Client\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Database\Factories\OrderFactory;
use Modules\Client\Enums\OrderStatus;


/**
 * @property int $id
 * @property int $company_id
 * @property int $client_id
 * @property int $location_id
 * @property int $truck_id
 * @property OrderStatus $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];


    protected $casts = [
        "status" => OrderStatus::class,
    ];

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}
