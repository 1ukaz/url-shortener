<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\UrlService;
use App\Repositories\UrlRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Models\Url;
use Illuminate\Support\Str;
use Mockery;

class UrlServiceTest extends TestCase
{
    protected $urlService;
    protected $urlRepositoryMock;
    protected $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mocks for the repositories
        $this->urlRepositoryMock = Mockery::mock(UrlRepositoryInterface::class);
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);

        // Inject mocks into the UrlService instance
        $this->urlService = new UrlService($this->urlRepositoryMock, $this->userRepositoryMock);
    }

    public function testShortenUrl()
    {
        $originalUrl = 'https://example.com/some/long/path';
        $userIdentifier = 'test-user-identifier';
        $shortenedPath = 'FCiAXLzd';
        $shortenedUrl = 'https://example.com/' . $shortenedPath;

        // Simulate the user creation or search
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('identifier')->andReturn($userIdentifier);
        $this->userRepositoryMock
            ->shouldReceive('firstOrCreate')
            ->with(['identifier' => $userIdentifier])
            ->andReturn($userMock);

        // Simulate the shorten URL creation
        $this->urlRepositoryMock
            ->shouldReceive('findByCode')
            ->with(Mockery::any())
            ->andReturn(null);

        $urlMock = Mockery::mock(Url::class);
        $urlMock->shouldReceive('getAttribute')->with('shortened_url')->andReturn($shortenedUrl);

        $this->urlRepositoryMock
            ->shouldReceive('create')
            ->andReturn($urlMock);

        // Ejecute the service
        $result = $this->urlService->shortenUrl($originalUrl, $userIdentifier);

        // Verifying results
        $this->assertEquals($shortenedUrl, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
