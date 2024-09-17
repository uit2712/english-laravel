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
    public function index()
    {
        return response()->json(GroupApi::getAll());
    }
}
