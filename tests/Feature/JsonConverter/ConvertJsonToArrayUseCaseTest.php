<?php

namespace Tests\Feature\JsonConverter;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Features\JsonConverter\Constants\JsonConverterSuccessMessage;
use Core\Features\JsonConverter\Facades\JsonConverterApi;
use Core\Models\ArrayResult;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\TestCase;

class ConvertJsonToArrayUseCaseTest extends TestCase
{
    public static function getListInvalidValues(): array
    {
        return [
            [null, []],
            ['', []],
            ['    ', []],
            [444, []],
            [0, []],
        ];
    }

    /**
     * @param mixed|null $input Input.
     * @param array $expectedValue Expected value.
     */
    #[DataProvider('getListInvalidValues')]
    public function testInvalidInputValues($input, $expectedValue): void
    {
        $expectResult = new ArrayResult();
        $expectResult->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'value');
        $expectResult->responseCode = HttpResponseCode::BAD_REQUEST;
        $expectResult->data = $expectedValue;

        $actualResult = JsonConverterApi::convertToArray($input);

        $this->assertFalse($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
    }

    public static function getListValidValues(): array
    {
        $input1 = new stdClass();
        $expectedValue1 = [];

        $input2 = new stdClass();
        $input2->test = 123;
        $expectedValue2 = ['test' => 123];

        $input3 = new stdClass();
        $input3->first = 456;
        $input3->second = 'abc';
        $expectedValue3 = ['first' => 456, 'second' => 'abc'];

        $input4 = [$input2, $input3];
        $expectedValue4 = [$expectedValue2, $expectedValue3];

        return [
            [$input1, $expectedValue1],
            [$input2, $expectedValue2],
            [$input3, $expectedValue3],
            [$input4, $expectedValue4],
        ];
    }

    /**
     * @param mixed|null $value Value.
     * @param array $expectedValue Expected value.
     */
    #[DataProvider('getListValidValues')]
    public function testConvertJsonToArraySuccess($value, $expectedValue): void
    {
        $expectResult = new ArrayResult();
        $expectResult->success = true;
        $expectResult->message = sprintf(JsonConverterSuccessMessage::CONVERT_JSON_TO_ARRAY_SUCCESS);
        $expectResult->data = $expectedValue;

        $actualResult = JsonConverterApi::convertToArray($value);

        $this->assertTrue($actualResult->success);
        $this->assertEquals($expectResult->success, $actualResult->success);
        $this->assertEquals($expectResult->message, $actualResult->message);
        $this->assertEquals($expectResult->responseCode, $actualResult->responseCode);
        $this->assertEqualsCanonicalizing($expectResult->data, $actualResult->data);
    }
}
