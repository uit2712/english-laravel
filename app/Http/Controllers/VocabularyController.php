<?php

namespace App\Http\Controllers;

use Core\Features\Vocabulary\Facades\VocabularyApi;
use OpenApi\Annotations as OA;

class VocabularyController extends Controller
{
    /**
     * @OA\Get(
     *      path="/vocabularies/readFromCsvFile",
     *      summary="Get list vocabularies from csv file",
     *      tags={"Vocabularies"},
     *      @OA\Response(
     *          response="200",
     *          description="Get list vocabularies from csv file success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ApiResult"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found any vocabulary(s)",
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
        $result = VocabularyApi::readFromCsvFile();
        return response()->json($result, $result->responseCode);
    }
}
