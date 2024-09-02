<?php

namespace App\Repositories;

use App\Models\Url;
use Illuminate\Support\Collection;

interface UrlRepositoryInterface
{
    /**
     * Creates a new URL into the database
     *
     * @param array $data
     * @return Url
     */
    public function create(array $data): Url;

    /**
     * Finds an URL by it's shorten version
     *
     * @param string $shortenedUrl
     * @return Url|null
     */
    public function findByShortenedUrl(string $shortenedUrl): ?Url;

    /**
     * Finds an URL by it's shorten code
     *
     * @param string $code
     * @return Url|null
     */
    public function findByCode(string $code): ?Url;

    /**
     * Finds all URLs associated to an user's UUID identifier
     *
     * @param string $userIdentifier
     * @return Collection
     */
    public function findByUserIdentifier(string $userIdentifier): Collection;

    /**
     * Deletes an URL assciated to a shorten code
     * 
     * @param string $code
     * @return bool
     */
    public function deleteUrlByCode(string $code): bool;
}
