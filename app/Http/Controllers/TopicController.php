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

    /**
     * @OA\Get(
     *      path="/topics/readFromCsvFile",
     *      summary="Get list topics from csv file",
     *      tags={"Topics"},
     *      @OA\Response(
     *          response="200",
     *          description="Get list topics from csv file success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found any topic(s)",
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
        $result = TopicApi::readFromCsvFile();
        return response()->json($result, $result->responseCode);
    }

    /**
     * @OA\Get(
     *      path="/topics/{id}/vocabularies",
     *      summary="Get list vocabularies by id",
     *      tags={"Topics"},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Get list vocabularies by id",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found any topic or vocabulary(s)",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     * )
     *
     * @param int|string|null $id Id
     */
    public function getListVocabulariesById($id)
    {
        $result = TopicApi::getListVocabulariesById($id);
        return response()->json($result, $result->responseCode);
    }
}
