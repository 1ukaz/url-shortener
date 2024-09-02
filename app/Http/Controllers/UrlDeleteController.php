<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlDeleteController extends UrlController
{
    /**
     * Method to delete an URL by it's code
     * 
     * @param Request $request
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Delete(
     *     path="/api/{code}",
     *     tags={"Available actions"},
     *     summary="Delete a shortened URL",
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
     *         description="URL deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="URL deleted successfully."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $code = $request->route('code');
        $this->urlService->deleteUrl($code);
        return $this->successResponse([], 'URL deleted successfully.');
    }

}
