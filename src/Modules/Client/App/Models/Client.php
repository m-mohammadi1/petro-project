<?php

namespace Modules\Client\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Database\Factories\ClientFactory;


/**
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Client extends Model
{
    use HasFactory;


    protected $fillable = [
        "company_id",
        "name",
    ];

    protected static function newFactory(): ClientFactory
    {
        return ClientFactory::new();
    }
}
