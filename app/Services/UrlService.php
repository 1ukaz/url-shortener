<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\UrlRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Models\Url;

class UrlService
{
    protected $urlRepository;
    protected $userRepository;

    /**
     * @param UrlRepositoryInterface $urlRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UrlRepositoryInterface $urlRepository, UserRepositoryInterface $userRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Shortens an URL and associates it with an user
     *
     * @param string $originalUrl
     * @param string $userIdentifier
     * @return string
     */
    public function shortenUrl(string $originalUrl, string $userIdentifier): string
    {
        // Find or create the user based in the user_identifier UUID string generated at the FE
        $user = $this->userRepository->firstOrCreate(
            ['identifier' => $userIdentifier]
        );

        // Generates an unique shorten URL
        [$shortenedPath, $shortenedUrl] = $this->generateUniqueShortenedUrl($originalUrl);

        // Save the URL and the shorten version and code through the Repository class
        $url = $this->urlRepository->create([
            'code' => $shortenedPath,
            'original_url' => $originalUrl,
            'shortened_url' => $shortenedUrl,
            'user_identifier' => $user->identifier,
        ]);

        return $url->shortened_url;
    }

    /**
     * Generates an unique shorten URL
     *
     * @return string
     */
    protected function generateUniqueShortenedUrl(string $originalUrl): array
    {
        // Split the host and the path from the original URL
        $parsedUrl = parse_url($originalUrl);
        $host = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

        do {
            // Gerenates the 8 characters hash for the path unitil it does no already exists
            $shortenedPath = Str::random(8);
            $shortenedUrl = $host . '/' . $shortenedPath;
        } while ($this->urlRepository->findByCode($shortenedPath));

        return [$shortenedPath, $shortenedUrl];
    }

    /**
     * Gets an original URL through a shorten URL code
     *
     * @param string $code
     * @return \App\Models\Url|null
     */
    public function getUrlByCode(string $code): ?Url
    {
        return $this->urlRepository->findByCode($code);
    }

    /**
     * Gets all the URLs associated to an user UUID identifier
     *
     * @param string $userIdentifier
     * @return \Illuminate\Support\Collection
     */
    public function getUserUrls(string $userIdentifier)
    {
        // Find the user based in the user_identifier
        $user = $this->userRepository->findByIdentifier($userIdentifier);
        if (!$user) {
            return collect([]);
        }
        return $user->urls()->get();
    }

    /**
     * Deletes an URL by it's shorten URL code
     * 
     * @param string $code
     * @return void
     */
    public function deleteUrl(string $code): void
    {
        $deleted = $this->urlRepository->deleteUrlByCode($code);
        if (!$deleted) {
            throw new \Exception('URL not found or could not be deleted.');
        }
    }
}
