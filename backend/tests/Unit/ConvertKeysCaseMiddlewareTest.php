<?php

namespace Tests\Unit;

use App\Http\Middleware\ConvertKeysCase;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ConvertKeysCaseMiddlewareTest extends TestCase {

    private ConvertKeysCase $middleware;

    public function setUp(): void {
        parent::setUp();
        $this->middleware = new ConvertKeysCase();
    }

    public function test_valid_case_success() {
        $this->expectNotToPerformAssertions();
        $this->middleware->convertToCase("snake", "variable");
    }

    public function test_invalid_case_throws_exception() {
        $this->expectException(InvalidArgumentException::class);
        $this->middleware->convertToCase("snek", "variable");
    }

    public function test_camel_to_snake_level_0_success() {
        $this->assertEquals("variable", $this->middleware->convertToCase("snake", "variable"));
        $this->assertEquals("variableValue", $this->middleware->convertToCase("snake", "variableValue"));
    }

    public function test_camel_to_snake_level_1_success() {
        $camel = ["itemKey" => "itemValue"];
        $expected = ["item_key" => "itemValue"];

        $this->assertEquals($expected, $this->middleware->convertToCase("snake", $camel));
    }

    public function test_camel_to_snake_level_2_success() {
        $camel = [
            "item1Key" => "item1Value",
            "item2Key" => [
                "item1Key" => "item1Value",
                "item2Key" => "item2Value"
            ]
        ];

        $expected = [
            "item1_key" => "item1Value",
            "item2_key" => [
                "item1_key" => "item1Value",
                "item2_key" => "item2Value"
            ]
        ];

        $this->assertEquals($expected, $this->middleware->convertToCase("snake", $camel));
    }

    public function test_snake_to_camel_level_0_success() {
        $this->assertEquals("variable", $this->middleware->convertToCase("camel", "variable"));
        $this->assertEquals("variable_value", $this->middleware->convertToCase("camel", "variable_value"));
    }

    public function test_snake_to_camel_level_1_success() {
        $snake = ["item_key" => "item_value"];
        $expected = ["itemKey" => "item_value"];

        $this->assertEquals($expected, $this->middleware->convertToCase("camel", $snake));
    }

    public function test_snake_to_camel_level_2_success() {
        $camel = [
            "item1_key" => "item1_value",
            "item2_key" => [
                "item1_key" => "item1_value",
                "item2_key" => "item2_value"
            ]
        ];

        $expected = [
            "item1Key" => "item1_value",
            "item2Key" => [
                "item1Key" => "item1_value",
                "item2Key" => "item2_value"
            ]
        ];

        $this->assertEquals($expected, $this->middleware->convertToCase("camel", $camel));
    }

    public function test_camel_to_camel_level_0_success() {
        $this->assertEquals("variable", $this->middleware->convertToCase("camel", "variable"));
        $this->assertEquals("variableValue", $this->middleware->convertToCase("camel", "variableValue"));
    }

    public function test_camel_to_camel_level_1_success() {
        $camel = ["itemKey" => "itemValue"];

        $this->assertEquals($camel, $this->middleware->convertToCase("camel", $camel));
    }

    public function test_camel_to_camel_level_2_success() {
        $camel = [
            "item1Key" => "item1Value",
            "item2Key" => [
                "item1Key" => "item1Value",
                "item2Key" => "item2Value"
            ]
        ];

        $this->assertEquals($camel, $this->middleware->convertToCase("camel", $camel));
    }

    public function test_snake_to_snake_level_0_success() {
        $this->assertEquals("variable", $this->middleware->convertToCase("snake", "variable"));
        $this->assertEquals("variable_value", $this->middleware->convertToCase("snake", "variable_value"));
    }

    public function test_snake_to_snake_level_1_success() {
        $snake = ["item_key" => "item_value"];

        $this->assertEquals($snake, $this->middleware->convertToCase("snake", $snake));
    }

    public function test_snake_to_snake_level_2_success() {
        $snake = [
            "item1_key" => "item1_value",
            "item2_key" => [
                "item1_key" => "item1_value",
                "item2_key" => "item2_value"
            ]
        ];

        $this->assertEquals($snake, $this->middleware->convertToCase("snake", $snake));
    }
}
