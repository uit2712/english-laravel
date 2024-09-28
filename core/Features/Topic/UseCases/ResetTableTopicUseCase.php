<?php

namespace Core\Features\Topic\UseCases;

use Core\Features\Topic\Facades\Topic;

class ResetTableTopicUseCase
{
    public function invoke()
    {
        return Topic::getRepo()->reset();
    }
}
