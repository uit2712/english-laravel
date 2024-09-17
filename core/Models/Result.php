<?php

namespace Core\Models;

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
    public $data = null;

    /**
     * @param Result $source Source.
     */
    public function copyWithoutData($source)
    {
        if (null == $source) {
            return;
        }

        $this->success = $source->success;
        $this->message = $source->message;
    }
}
