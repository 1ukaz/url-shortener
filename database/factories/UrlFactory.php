<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    protected $model = Url::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $code = \Str::random(8);
        $url = $this->faker->url;
        $parsedUrl = parse_url($url);
        $host = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        return [
            'original_url' => $url,
            'shortened_url' => $host .'/'. $code,
            'code' => $code,
            'user_identifier' => $this->faker->uuid,
        ];
    }
}
