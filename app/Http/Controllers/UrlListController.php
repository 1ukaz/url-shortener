<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlListController extends UrlController
{
    /**
     * Method to get all current user's URLs.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Get(
     *     path="/api/list",
     *     tags={"Available actions"},
     *     summary="Get the list of URLs for the current user",
     *     @OA\Parameter(
     *         name="user_identifier",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="5564dbcb-f26b-4733-a459-d0ef66e34769"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URLs retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="URLs retrieved successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="urls",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=2
     *                         ),
     *                         @OA\Property(
     *                             property="code",
     *                             type="string",
     *                             example="aHQk02dL"
     *                         ),
     *                         @OA\Property(
     *                             property="original_url",
     *                             type="string",
     *                             example="https://www.manznas.com/las/verdes/son/para/cocinar"
     *                         ),
     *                         @OA\Property(
     *                             property="shortened_url",
     *                             type="string",
     *                             example="https://www.manznas.com/aHQk02dL"
     *                         ),
     *                         @OA\Property(
     *                             property="user_identifier",
     *                             type="string",
     *                             example="5564dbcb-f26b-4733-a459-d0ef66e34769"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2024-08-31T18:08:33.000000Z"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             format="date-time",
     *                             example="2024-08-31T18:08:33.000000Z"
     *                         )
     *                     )
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
            'user_identifier' => 'required|string',
        ]);
        
        // Get current user's URLs
        $urls = $this->urlService->getUserUrls($validatedData['user_identifier']);

        // Return an error JSON response if no URLs for the user identifier
        if ($urls->count() === 0) {
            return $this->errorResponse('URLs for selected user not found!', 404);
        }
        
        // Return a JSON response
        return $this->successResponse(
            ['urls' => $urls],
            'URLs retrieved successfully'
        );
    }

}
