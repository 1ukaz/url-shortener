<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlRedirectController extends UrlController
{
    /**
     * Method to get an URL by it's code.
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/api/{code}",
     *     tags={"Available actions"},
     *     summary="Get a shortened URL",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="The code of the shortened URL"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL was found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="URL was found"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=7
     *                 ),
     *                 @OA\Property(
     *                     property="code",
     *                     type="string",
     *                     example="zAWNGoNq"
     *                 ),
     *                 @OA\Property(
     *                     property="original_url",
     *                     type="string",
     *                     example="https://www.example.com/some/really/long/path"
     *                 ),
     *                 @OA\Property(
     *                     property="shortened_url",
     *                     type="string",
     *                     example="https://www.example.com/zAWNGoNq"
     *                 ),
     *                 @OA\Property(
     *                     property="user_identifier",
     *                     type="string",
     *                     example="5564dbcb-f26b-4733-a459-d0ef66e34769"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-08-31T21:32:39.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-08-31T21:32:39.000000Z"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        // Get the URL through the URL service
        $code = $request->route('code');
        $url = $this->urlService->getUrlByCode($code);
        
        if (!$url) {
            return $this->errorResponse('URL not found!', 404);
        }
        
        // Opcional: Redirect through the response itself
        // return redirect()->to($url->original_url);
        
        // Return the URL data in JSON format
        return $this->successResponse($url, 'URL was found');
    }

}
