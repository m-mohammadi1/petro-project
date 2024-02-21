<?php

namespace Modules\Company\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Company\Database\factories\CompanyFactory;


/**
 * @property int $id
 * @property int $admin_id
 * @property string $name
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Company extends Model
{
    use HasFactory;


    protected $fillable = [
        'admin_id',
        'name',
    ];

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}
