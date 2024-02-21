<?php

namespace Modules\Company\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Company\Database\factories\TruckFactory;


/**
 * @property int $id
 * @property string $driver_name
 * @property int $company_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Truck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'driver_name',
        'company_id',
    ];

    protected static function newFactory(): TruckFactory
    {
        return TruckFactory::new();
    }
}
