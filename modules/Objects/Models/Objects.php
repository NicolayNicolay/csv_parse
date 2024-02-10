<?php

namespace Modules\Objects\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Objects
 *
 * @mixin Builder
 *
 * @property int $id
 * @property string $code
 * @property string $level_first
 * @property string $level_second
 * @property string $level_third
 * @property string $price
 * @property string $price_cp
 * @property float $count
 * @property string $properties
 * @property string $unit
 * @property string $description
 * @property string $join_purchases
 * @property string $images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Objects extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'level_first',
        'level_second',
        'level_third',
        'price',
        'price_cp',
        'count',
        'properties',
        'unit',
        'description',
        'join_purchases', //Необходимо реализовать в прод как таблицу отношений
        'images',         //Необходимо реализовать в прод как таблицу отношений
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i:s',
        'updated_at' => 'date:d.m.Y H:i:s',
    ];

    protected $appends = [
        'groups_name',
    ];

    protected $guarded = ['code'];

    public function getGroupsNameAttribute(): ?string
    {
        $levels = [];
        if ($this->level_first) {
            $levels[] = $this->level_first;
        }
        if ($this->level_second) {
            $levels[] = $this->level_second;
        }
        if ($this->level_third) {
            $levels[] = $this->level_third;
        }
        return implode(" / ", $levels);
    }
}
