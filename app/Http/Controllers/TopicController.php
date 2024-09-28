<?php

namespace App\Http\Controllers;

use Core\Features\Topic\Facades\TopicApi;
use OpenApi\Annotations as OA;

class TopicController extends Controller
{
    /**
     * @OA\Get(
     *      path="/topics/{id}",
     *      summary="Get topic by id",
     *      tags={"Topics"},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Get topic by id",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     * )
     *
     * @param int|string|null $id Id
     */
    public function getById($id)
    {
        $result = TopicApi::getById($id);
        return response()->json($result, $result->responseCode);
    }
}
