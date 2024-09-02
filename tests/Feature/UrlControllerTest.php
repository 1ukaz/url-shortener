<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShortenUrl()
    {
        $response = $this->postJson(env('APP_URL') . '/shorten', [
            'original_url' => 'https://example.com/some/path',
            'user_identifier' => 'some-unique-identifier'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         'shortened_url'
                     ]
                 ]);

        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://example.com/some/path'
        ]);
    }

    public function testListUrls()
    {
        $user = User::factory()->create();
        $urls = Url::factory()->count(3)->create([
            'user_identifier' => $user->identifier
        ]);
    
        $response = $this->getJson(env('APP_URL') . '/list?user_identifier=' . $user->identifier);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'URLs retrieved successfully',
            'data' => ['urls' => $urls->map(function ($url) {
                return [
                    'original_url' => $url->original_url,
                    'shortened_url' => $url->shortened_url,
                ];
            })->toArray()],
        ]);
    }    

    public function testRedirectUrl()
    {
        $code = \Str::random(8);
        $url = Url::factory()->create([
            'original_url' => 'https://example.com/some/path',
            'shortened_url' => 'https://example.com/' . $code,
            'code' => $code
        ]);

        $response = $this->get(env('APP_URL') . "/{$code}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'URL was found',
                'data' => [
                    'original_url' => $url->original_url
                ]
            ]);

    }

    public function testDeleteUrl()
    {
        $code = \Str::random(8);
        $url = Url::factory()->create([
            'original_url' => 'https://example.com/some/path',
            'shortened_url' => 'https://example.com/' . $code,
            'code' => $code
        ]);
    
        $response = $this->delete(env('APP_URL') . "/{$url->code}");
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'URL deleted successfully.',
                 ]);
    
        $this->assertDatabaseMissing('urls', ['code' => $url->code]);
    }
}
