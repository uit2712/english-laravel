<?php

namespace Tests\Feature\JsonConverter;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\Result;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\TestCase;

class EncodeJsonToStringUseCaseTest extends TestCase
{
    public static function getListInvalidValues(): array
    {
        return [
            [null],
            [''],
            ['    '],
            [444],
            [0],
        ];
    }

    /**
     * @param mixed|null $value Value.
     */
    #[DataProvider('getListInvalidValues')]
    public function testInvalidInputValues($value): void
    {
        $expectResult = new Result();
        $expectResult->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'value');
        $expectResult->responseCode = HttpResponseCode::BAD_REQUEST;

        $actualResult = JsonConverterApi::encode($value);

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
    }

    public static function getListValidValues(): array
    {
        $value1 = new stdClass();
        $value2 = new stdClass();
        $value2->test = 123;

        return [
            [$value1],
            [$value2],
        ];
    }

    /**
     * @param mixed|null $value Value.
     */
    #[DataProvider('getListValidValues')]
    public function testDecodeStringSuccess($value): void
    {
        $expectResult = new Result();
        $expectResult->success = true;
        $expectResult->message = sprintf(JsonConverterSuccessMessage::ENCODE_JSON_TO_STRING_SUCCESS);
        $expectResult->data = json_encode($value);

        $actualResult = JsonConverterApi::encode($value);

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
        $this->assertEqualsCanonicalizing($expectResult->data, $actualResult->data);
    }
}
