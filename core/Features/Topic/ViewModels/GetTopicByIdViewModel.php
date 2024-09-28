<?php

namespace Core\Features\Topic\ViewModels;

use Core\Constants\ErrorMessage;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;
use Core\Models\Result;

class GetTopicByIdViewModel
{
    /**
     * @var int|null
     */
    public $id = 0;

    /**
     * @param string|int|null $id Id.
     */
    public function __construct($id)
    {
        if (StringHelper::isHasValue($id) || NumberHelper::isPositiveInteger($id)) {
            $this->id = intval($id);
        }
    }

    public function validate(): Result
    {
        $result = new Result();
        if (NumberHelper::isPositiveInteger($this->id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $result->success = true;
        return $result;
    }
}
