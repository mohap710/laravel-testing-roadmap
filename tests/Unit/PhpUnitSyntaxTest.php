<?php

use PHPUnit\Framework\TestCase;

class PhpUnitSyntaxTest extends TestCase
{
    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     dump('setup');
    // }

    // protected function tearDown(): void
    // {
    //     dump('cleanup');

    //     parent::tearDown();
    // }

    public function test_number_larger_than_five()
    {
        // dump('test is running');
        $numberLargerThanFive = 20;
        $this->assertGreaterThan(5, $numberLargerThanFive, "$numberLargerThanFive is not larger than 5");
    }

    public function test_assert_equal()
    {
        $this->assertEquals(1, '1');
    }

    // This Failed because same uses Strict comparsion "===" which compare the type and the value
    // public function test_assert_same()
    // {
    //     $this->assertSame(1, '1');
    // }
}
