<?php

namespace App\Models;

use Core\Models\Result;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 */
class ApiResult extends Result
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
}
