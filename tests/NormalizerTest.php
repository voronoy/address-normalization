<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZeroDaHero\Normalizer;
use ZeroDaHero\Address;

class NormalizerTest extends TestCase
{
    /** @test */
    public function testReturnsAddressClass()
    {
        $normalizer = new Normalizer();
        $address = $normalizer->parse('1234 Main St SE, Minneapolis, MN 55401');

        $this->assertInstanceOf(Address::class, $address);
    }

    public function normalizesAddressesDataProvider()
    {
        return [
            [
                '1234 Main St. SE, Minneapolis, MN 55401',
                '1234 Main Street Southeast, Minneapolis, MN 55401'
            ],
            [
                '1234 Main St. SE, Minneapolis, MN 55401',
                '1234 Main St SE, Minneapolis, Minnesota 55401'
            ],
            [
                '1234 Main St. SE, Minneapolis, MN 55401',
                '1234 Main St southeast, Minneapolis, Minnesota 55401'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider normalizesAddressesDataProvider
     */
    public function testNormalizesAddresses($firstAddress, $secondAddress)
    {
        $normalizer = new Normalizer();

        $this->assertEquals(
            (string)$normalizer->parse($firstAddress),
            (string)$normalizer->parse($secondAddress)
        );
    }
}
