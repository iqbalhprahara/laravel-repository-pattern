<?php

namespace App\Actions\User;

use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class DeleteUserByUuid
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    public function execute(string $uuid)
    {
        return DB::transaction(fn () => $this->userRepository->delete($uuid));
    }
}
