<?php

namespace App\Repositories;

use App\Models\Url;
use Illuminate\Support\Collection;

class UrlRepository implements UrlRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $data): Url
    {
        return Url::create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function findByShortenedUrl(string $shortenedUrl): ?Url
    {
        return Url::where('shortened_url', $shortenedUrl)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByCode(string $code): ?Url
    {
        return Url::where('code', $code)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserIdentifier(string $userIdentifier): Collection
    {
        return Url::where('user_identifier', $userIdentifier)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteUrlByCode(string $code): bool
    {
        $url = Url::where('code', $code)->first();
        if ($url) {
            $url->delete();
            return true;
        }
        return false;
    }
}
