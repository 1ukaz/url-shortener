<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlShortenController extends UrlController
{
    /**
     * Method to shorten an URL.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/api/shorten",
     *     tags={"Available actions"},
     *     summary="Shorten a URL",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="original_url",
     *                 type="string",
     *                 description="The original URL to be shortened",
     *                 example="https://example.com/some/long/path"
     *             ),
     *             @OA\Property(
     *                 property="user_identifier",
     *                 type="string",
     *                 description="The identifier of the user",
     *                 example="5564dbcb-f26b-4733-a459-d0ef66e34769"
     *             ),
     *             required={"original_url", "user_identifier"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="URL successfully shortened",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="URL successfully shortened"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="shortened_url",
     *                     type="string",
     *                     example="https://example.com/abcD1234"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        // Validate received data
        $validatedData = $request->validate([
            'original_url' => 'required|url',
            'user_identifier' => 'required|string',
        ]);
        
        // URL shortener service delegation call
        $shortenedUrl = $this->urlService->shortenUrl(
            $validatedData['original_url'],
            $validatedData['user_identifier']
        );
        
        // Return a JSON response
        return $this->successResponse(
            ['shortened_url' => $shortenedUrl],
            'URL successfully created and shortened',
            201
        );
    }
}
