<?php

namespace Framework\Features\FilePath\Repositories;

use Core\Features\FilePath\InterfaceAdapters\FilePathRepositoryInterface;

class FilePathRepository implements FilePathRepositoryInterface
{
    public function getBasePath(): string
    {
        return base_path();
    }
}
