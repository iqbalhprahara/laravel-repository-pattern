<?php

namespace App\Actions\User;

use App\Contracts\Repositories\HourlyRecordRepository;
use App\Contracts\Repositories\RandomUserRepository;
use App\Contracts\Repositories\UserRepository;
use App\DataTransferObjects\HourlyRecordData;
use App\DataTransferObjects\UserData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class IngestUserData
{
    /**
     * The default value of how much user data to be ingested
     *
     * @var int
     */
    protected const DEFAULT_INGEST_COUNT = 20;

    public function __construct(
        protected RandomUserRepository $randomUserRepository,
        protected UserRepository $userRepository,
        protected HourlyRecordRepository $hourlyRecordRepository,
    ) {}

    public function execute(Carbon $timestamp, int $ingestCount = self::DEFAULT_INGEST_COUNT)
    {
        $results = $this->generateUser($ingestCount, $timestamp);
        $maleCount = 0;
        $femaleCount = 0;

        // save each user
        foreach ($results as $userData) {
            if (! $this->userRepository->existsByUuid($userData->uuid)) {
                // only new user will be counted to be saved as hourly record
                if ($userData->gender == 'male') {
                    $maleCount++;
                } else {
                    $femaleCount++;
                }

                $this->userRepository->create($userData);
            } else {
                $this->userRepository->update($userData);
            }
        }

        // save hourly record capture
        $this->hourlyRecordRepository->create(
            new HourlyRecordData($timestamp, $maleCount, $femaleCount)
        );
    }

    /**
     * Generate random user from repository
     *
     * @return Collection<UserData>
     */
    protected function generateUser(int $ingestCount, Carbon $timestamp): Collection
    {
        return $this->randomUserRepository->get($ingestCount)
            ->map(fn ($randomUserData): UserData => UserData::fromRandomUserData($randomUserData, $timestamp));
    }
}
