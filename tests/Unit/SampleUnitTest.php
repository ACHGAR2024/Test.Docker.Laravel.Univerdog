<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SampleUnitTest extends TestCase
{
    public function test_example()
    {
        // Simple unit test example
        $this->assertTrue(true);
    }

    public function test_addition()
    {
        // Simple test to verify addition
        $sum = 2 + 3;
        $this->assertEquals(5, $sum, "The sum of 2 and 3 should be 5");
    }

    public function test_string_contains()
    {
        // Test to check if a string contains a substring
        $string = "Hello world";
        $this->assertStringContainsString('world', $string, "The string should contain 'world'");
    }
}