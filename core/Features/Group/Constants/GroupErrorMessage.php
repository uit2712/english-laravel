<?php

namespace Core\Features\Group\Constants;

use Core\Constants\ErrorMessage;

class GroupErrorMessage
{
    public const INVALID_PARAMETER_PAGE_INDEX = ErrorMessage::INVALID_PARAMETER . ': pageIndex must >= 0';
    public const INVALID_PARAMETER_PER_PAGE = ErrorMessage::INVALID_PARAMETER . ': perPage must > 0';
}
