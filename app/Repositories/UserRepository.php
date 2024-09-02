<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function firstOrCreate(array $attributes, array $values = []): User
    {
        return User::firstOrCreate($attributes, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function findByIdentifier(string $identifier): ?User
    {
        return User::where('identifier', $identifier)->first();
    }
}
