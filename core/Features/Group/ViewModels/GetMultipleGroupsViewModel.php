<?php

namespace Core\Features\Group\ViewModels;

use Core\Constants\HttpResponseCode;
use Core\Features\Group\Constants\GroupErrorMessage;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;
use Core\Models\Result;

class GetMultipleGroupsViewModel
{
    /**
     * @var int|null
     */
    public $pageIndex = 0;

    /**
     * @var int|null
     */
    public $perPage = 0;

    /**
     * @param string|int|null $pageIndex Page index.
     * @param string|int|null $perPage Per page.
     */
    public function __construct($pageIndex, $perPage)
    {
        if (StringHelper::isHasValue($pageIndex) || NumberHelper::isPositiveIntegerIncludeZero($pageIndex)) {
            $this->pageIndex = intval($pageIndex);
        }

        if (StringHelper::isHasValue($perPage) || NumberHelper::isPositiveInteger($perPage)) {
            $this->perPage = intval($perPage);
        }
    }

    public function validate(): Result
    {
        $result = new Result();
        if (NumberHelper::isPositiveIntegerIncludeZero($this->pageIndex) === false) {
            $result->message = sprintf(GroupErrorMessage::INVALID_PARAMETER_PAGE_INDEX, 'pageIndex');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        if (NumberHelper::isPositiveInteger($this->perPage) === false) {
            $result->message = sprintf(GroupErrorMessage::INVALID_PARAMETER_PER_PAGE, 'perPage');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $result->success = true;
        return $result;
    }
}
