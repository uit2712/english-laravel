<?php

namespace App\Http\Controllers;

use Core\Features\Group\Facades\GroupApi;
use OpenApi\Annotations as OA;

class GroupController extends Controller
{
    /**
     * @OA\Get(
     *      path="/groups",
     *      summary="Get groups",
     *      tags={"Groups"},
     *      @OA\Response(
     *          response="200",
     *          description="Get list groups",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      )
     * )
     */
    public function getAll()
    {
        $result = GroupApi::getAll();
        return response()->json($result, $result->responseCode);
    }

    /**
     * @OA\Get(
     *      path="/groups/{id}",
     *      summary="Get group by id",
     *      tags={"Groups"},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Get group by id",
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
        $result = GroupApi::getById($id);
        return response()->json($result, $result->responseCode);
    }
}
