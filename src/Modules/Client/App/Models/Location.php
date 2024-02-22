<?php

namespace Modules\Client\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Database\Factories\LocationFactory;

/**
 * @property int $id
 * @property int $client_id
 * @property string $title
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        "client_id",
        "title",
    ];

    protected static function newFactory(): LocationFactory
    {
        return LocationFactory::new();
    }
}
