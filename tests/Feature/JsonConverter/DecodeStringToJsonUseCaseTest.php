<?php

namespace Tests\Feature\JsonConverter;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Features\JsonConverter\Constants\JsonConverterErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\Result;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DecodeStringToJsonUseCaseTest extends TestCase
{
    public static function getListNullOrEmptyValues(): array
    {
        return [
            [null],
            [''],
            ['      '],
        ];
    }

    /**
     * @param string|null $value Value.
     */
    #[DataProvider('getListNullOrEmptyValues')]
    public function testReturnsNullOrEmptyValue($value): void
    {
        $expectResult = new Result();
        $expectResult->message = sprintf(ErrorMessage::NULL_OR_EMPTY_PARAMETER, 'value');
        $expectResult->responseCode = HttpResponseCode::BAD_REQUEST;

        $actualResult = JsonConverterApi::decode($value);

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
    }

    public static function getListInvalidValues(): array
    {
        return [
            ['{""}'],
            ['{"test": 123} 456'],
        ];
    }

    /**
     * @param string|null $value Value.
     */
    #[DataProvider('getListInvalidValues')]
    public function testCanNotDecodeString($value): void
    {
        $expectResult = new Result();
        $expectResult->message = sprintf(JsonConverterErrorMessage::CAN_NOT_DECODE_STRING);
        $expectResult->responseCode = HttpResponseCode::BAD_REQUEST;

        $actualResult = JsonConverterApi::decode($value);

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
    }

    public static function getListValidValues(): array
    {
        return [
            ['{}'],
            ['{"test": 123}'],
        ];
    }

    /**
     * @param string|null $value Value.
     */
    #[DataProvider('getListValidValues')]
    public function testDecodeStringSuccess($value): void
    {
        $expectResult = new Result();
        $expectResult->success = true;
        $expectResult->message = sprintf(JsonConverterSuccessMessage::DECODE_STRING_TO_JSON_SUCCESS);
        $expectResult->data = json_decode($value);

        $actualResult = JsonConverterApi::decode($value);

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
        $this->assertEqualsCanonicalizing($expectResult->data, $actualResult->data);
    }
}
