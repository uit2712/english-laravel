<?php

namespace App\Http\Controllers;

use Core\Features\Cache\Facades\CustomCacheApi;
use OpenApi\Annotations as OA;

class CacheController extends Controller
{
    /**
     * @OA\Get(
     *      path="/cache/checkConnection",
     *      summary="Check cache connection",
     *      tags={"Cache"},
     *      @OA\Response(
     *          response="200",
     *          description="Check cache connection result",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      )
     * )
     */
    public function checkConnection()
    {
        $result = CustomCacheApi::checkConnection();
        return response()->json($result, $result->responseCode);
    }

    /**
     * @OA\Delete(
     *      path="/cache/flushAll",
     *      summary="Flush all cache",
     *      tags={"Cache"},
     *      @OA\Response(
     *          response="200",
     *          description="Flush all cache",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      )
     * )
     */
    public function flushAll()
    {
        $result = CustomCacheApi::flushAll();
        return response()->json($result, $result->responseCode);
    }
}
