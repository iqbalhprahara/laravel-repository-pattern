<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
{
    /**
     * Get eloquent model instance for respository
     */
    abstract protected function model(): Model;
}
