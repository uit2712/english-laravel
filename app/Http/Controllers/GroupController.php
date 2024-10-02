<?php

namespace App\Http\Controllers;

use Core\Features\Group\Facades\GroupApi;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class GroupController extends Controller
{
    /**
     * @OA\Get(
     *      path="/groups",
     *      summary="Get groups",
     *      tags={"Groups"},
     *      @OA\Parameter(
     *          in="query",
     *          name="page",
     *          description="Page",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          in="query",
     *          name="perPage",
     *          description="Per page",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Get multiple groups",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found any group(s)",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      )
     * )
     *
     */
    public function getMultiple(Request $request)
    {
        $result = GroupApi::getMultiple($request->query('page'), $request->query('perPage'));
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
     *      @OA\Response(
     *          response="404",
     *          description="Not found any group",
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

    /**
     * @OA\Get(
     *      path="/groups/{id}/topics",
     *      summary="Get list topics by id",
     *      tags={"Groups"},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Get list topics by id",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found any group or topic(s)",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     * )
     *
     * @param int|string|null $id Id
     */
    public function getListTopicsById($id)
    {
        $result = GroupApi::getListTopicsById($id);
        return response()->json($result, $result->responseCode);
    }

    /**
     * @OA\Get(
     *      path="/groups/readFromCsvFile",
     *      summary="Get list groups from csv file",
     *      tags={"Groups"},
     *      @OA\Response(
     *          response="200",
     *          description="Get list groups from csv file success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found any group(s)",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      )
     * )
     *
     */
    public function readFromCsvFile()
    {
        $result = GroupApi::readFromCsvFile();
        return response()->json($result, $result->responseCode);
    }
}
