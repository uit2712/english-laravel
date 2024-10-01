<?php

namespace Tests\Feature\FilePath;

use Core\Features\FilePath\Facades\FilePathApi;
use Tests\TestCase;

class GetBasePathUseCaseTest extends TestCase
{
    public function testReturnsValidFilePath(): void
    {
        $actualResult = FilePathApi::getBasePath();

        $this->assertNotEmpty($actualResult);
    }
}
