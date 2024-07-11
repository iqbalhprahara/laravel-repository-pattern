<?php

namespace App\Models;

use App\Observers\User\UserDeletedObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[
    ObservedBy([
        UserDeletedObserver::class,
    ])
]
class User extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'gender',
        'name',
        'location',
        'age',
    ];

    protected $casts = [
        'name' => 'array',
        'location' => 'array',
    ];

    /**
     * Get full name attribute
     */
    protected function getFullNameAttribute(): string
    {
        return $this->name['title'].' '.$this->name['first'].' '.$this->name['last'];
    }

    /**
     * Get Parsed Location
     */
    protected function getParsedLocationAttribute(): array
    {
        return [
            'city' => $this->location['city'],
            'state' => $this->location['state'],
            'street' => $this->location['street']['name'].' '.$this->location['street']['number'],
            'country' => $this->location['country'],
            'postcode' => $this->location['postcode'],
            'timezone' => $this->location['timezone']['description'].' '.$this->location['timezone']['offset'],
            'coordinates' => $this->location['coordinates']['latitude'].', '.$this->location['coordinates']['longitude'],
        ];
    }
}
