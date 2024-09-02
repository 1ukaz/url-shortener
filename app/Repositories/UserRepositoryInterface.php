<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Find the first user matching the given attributes or creates it
     *
     * @param array $attributes
     * @param array $values
     * @return User
     */
    public function firstOrCreate(array $attributes, array $values = []): User;

    /**
     * Finds a user by it's UUID identifier
     *
     * @param string $identifier
     * @return User|null
     */
    public function findByIdentifier(string $identifier): ?User;
}
