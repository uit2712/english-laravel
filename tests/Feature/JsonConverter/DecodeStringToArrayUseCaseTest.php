<?php

namespace Tests\Feature\JsonConverter;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Features\JsonConverter\Constants\JsonConverterErrorMessage;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\ArrayResult;
use Core\Models\Result;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DecodeStringToArrayUseCaseTest extends TestCase
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

        $actualResult = JsonConverterApi::decodeAsArray($value);

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
        $expectResult = new ArrayResult();
        $expectResult->message = sprintf(JsonConverterErrorMessage::CAN_NOT_DECODE_STRING);
        $expectResult->responseCode = HttpResponseCode::BAD_REQUEST;

        $actualResult = JsonConverterApi::decodeAsArray($value);

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
    }

    public static function getListValidValues(): array
    {
        $input1 = '{}';
        $expectedValue1 = [];

        $input2 = '{"test": 123}';
        $expectedValue2 = ['test' => 123];

        $input3 = '{"test": 123, "test3": "hello"}';
        $expectedValue3 = ['test' => 123, 'test3' => 'hello'];

        $input4 = '[1, "456", 4444, null]';
        $expectedValue4 = [1, '456', 4444, null];

        return [
            [$input1, $expectedValue1],
            [$input2, $expectedValue2],
            [$input3, $expectedValue3],
            [$input4, $expectedValue4],
        ];
    }

    /**
     * @param string|null $input Input.
     * @param array|null $expectedValue Expected value.
     */
    #[DataProvider('getListValidValues')]
    public function testDecodeStringSuccess($input, $expectedValue): void
    {
        $expectResult = new ArrayResult();
        $expectResult->success = true;
        $expectResult->message = sprintf(JsonConverterSuccessMessage::DECODE_STRING_TO_ARRAY_SUCCESS);
        $expectResult->data = $expectedValue;

        $actualResult = JsonConverterApi::decodeAsArray($input);

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
        $this->assertEqualsCanonicalizing($expectResult->data, $actualResult->data);
    }
}
