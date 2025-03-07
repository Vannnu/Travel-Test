<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class BaseModel.
 */
class BaseModel extends Model
{
    /**
     * Function to generate uuid to store as primary key in the DB.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($model): void {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
