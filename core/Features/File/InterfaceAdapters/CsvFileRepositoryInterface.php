<?php

namespace Core\Features\File\InterfaceAdapters;

use Core\Models\Result;

interface CsvFileRepositoryInterface
{
    /**
     * @param string|null $filePath File path.
     */
    public function read($filePath): Result;
}
