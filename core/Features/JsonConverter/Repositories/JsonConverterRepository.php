<?php

namespace Core\Features\JsonConverter\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Features\JsonConverter\Constants\JsonConverterErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\InterfaceAdapters\JsonConverterRepositoryInterface;
use Core\Helpers\StringHelper;
use Core\Models\ArrayResult;
use Core\Models\Result;

class JsonConverterRepository implements JsonConverterRepositoryInterface
{
    public function decode($value): Result
    {
        $result = new Result();

        if (StringHelper::isHasValue($value) === false) {
            $result->message = sprintf(ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $value = json_decode($value);
        if (false === $value || null === $value) {
            $result->message = sprintf(JsonConverterErrorMessage::CAN_NOT_DECODE_STRING);
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $result->success = true;
        $result->message = sprintf(JsonConverterSuccessMessage::DECODE_STRING_TO_JSON_SUCCESS);
        $result->data = $value;

        return $result;
    }

    public function decodeAsArray($value): ArrayResult
    {
        $result = new ArrayResult();

        if (StringHelper::isHasValue($value) === false) {
            $result->message = sprintf(ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $value = json_decode($value, true);
        if (is_array($value) === false) {
            $result->message = sprintf(JsonConverterErrorMessage::CAN_NOT_DECODE_STRING);
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $result->success = true;
        $result->message = sprintf(JsonConverterSuccessMessage::DECODE_STRING_TO_ARRAY_SUCCESS);
        $result->data = $value;

        return $result;
    }

    public function encode($value): Result
    {
        $result = new Result();

        if (is_object($value) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'value');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $result->success = true;
        $result->message = sprintf(JsonConverterSuccessMessage::ENCODE_JSON_TO_STRING_SUCCESS);
        $result->data = json_encode($value);

        return $result;
    }

    public function convertToArray($value): ArrayResult
    {
        $result = new ArrayResult();

        return $result;
    }
}
