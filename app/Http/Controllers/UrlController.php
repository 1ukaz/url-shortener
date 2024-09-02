<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="URL Shortener API Documentation",
 *     version="1.0.0",
 *     description="Here you will find the available actions from the API",
 *     @OA\Contact(
 *         email="lukaz3nole@yahoo.com.ar"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\Tag(
 *     name="Available actions",
 *     description="Operations related to URL management"
 * )
 */

class UrlController extends Controller
{
    use ApiResponse;

    protected $urlService;

    /**
     * @param UrlService $urlService
     */
    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function __invoke(Request $request)
    {
        return $this->successResponse(
            [],
            'There is nothing here except the proof that the API works'
        );
    }
}
