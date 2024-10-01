<?php

namespace Core\Features\FilePath\UseCases;

use Core\Features\FilePath\Facades\FilePath;

class GetBasePathUseCase
{
    public function invoke()
    {
        return FilePath::getRepo()->getBasePath();
    }
}
