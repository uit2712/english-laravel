<?php

namespace Core\Features\File\UseCases;

use Core\Features\File\Facades\CsvFile;

class ReadCsvFileUseCase
{
    /**
     * @param string|null $filePath File path.
     */
    public function invoke($filePath)
    {
        return CsvFile::getRepo()->read($filePath);
    }
}
