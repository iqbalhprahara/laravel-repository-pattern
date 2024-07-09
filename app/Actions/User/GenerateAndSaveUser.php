<?php

namespace App\Actions\User;

use App\Contracts\Repositories\RandomUserRepository;
use App\Contracts\Repositories\UserRepository;
use App\DataTransferObjects\UserData;

class GenerateAndSaveUser
{
    protected const DEFAULT_GENERATE_COUNT = 20;

    public function __construct(
        protected RandomUserRepository $randomUserRepository,
        protected UserRepository $userRepository,
    ) {}

    public function execute(int $generateCount = self::DEFAULT_GENERATE_COUNT)
    {
        $results = $this->randomUserRepository->get($generateCount);
        foreach ($results as $randomUser) {
            $dto = UserData::fromRandomUserData($randomUser);

            if (!$this->userRepository->uuidExists($dto->uuid)) {
                $this->userRepository->create($dto);
            } else {
                $this->userRepository->update($dto);
            }
        }
    }
}
