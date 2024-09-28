<?php

namespace Core\Models;

use Core\Constants\HttpResponseCode;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class Result
{
    /**
     * @OA\Property(type="boolean")
     */
    public $success = false;
    /**
     * @OA\Property(type="string")
     */
    public $message = '';
    /**
     * @OA\Property(type="number")
     */
    public $responseCode = HttpResponseCode::OK;
    public $data = null;

    /**
     * @param Result $source Source.
     */
    public function copyWithoutData($source)
    {
        if (null == $source) {
            return $this;
        }

        $this->success = $source->success;
        $this->message = $source->message;
        $this->responseCode = $source->responseCode;
        return $this;
    }

    public function isHasObjectData()
    {
        return $this->success && null !== $this->data;
    }

    public function isHasArrayData()
    {
        return $this->success && is_array($this->data);
    }

    public function isHasNumericData()
    {
        return $this->success && is_numeric($this->data);
    }

    public function isHasBoolData()
    {
        return $this->success && is_bool($this->data);
    }
}
