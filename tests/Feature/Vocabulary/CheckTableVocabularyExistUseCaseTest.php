<?php

namespace Tests\Feature\Vocabulary;

use Core\Features\Vocabulary\Facades\VocabularyApi;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CheckTableVocabularyExistUseCaseTest extends TestCase
{
    public function testTableExisted()
    {
        Artisan::call('migrate');

        $expectedResult = true;
        $actualResult = VocabularyApi::isTableExisted();

        $this->assertEquals($expectedResult, $actualResult, '1234');
    }
}
