<?php

namespace Core\Features\FilePath\InterfaceAdapters;

interface FilePathRepositoryInterface
{
    public function getBasePath(): string;
}
