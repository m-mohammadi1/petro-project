<?php

namespace Modules\Auth\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Database\factories\RoleFactory;


/**
 * @property int $id
 * @property int $name
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class Role extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }
}
