<?php

namespace App\Models;

use App\Observers\DailyRecord\FemaleCountObserver;
use App\Observers\DailyRecord\MaleCountObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[
    ObservedBy([
        MaleCountObserver::class,
        FemaleCountObserver::class,
    ])
]
class DailyRecord extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'date';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'male_count',
        'female_count',
    ];

    protected $casts = [
        'date' => 'immutable_date',
    ];
}
