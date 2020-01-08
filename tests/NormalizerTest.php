<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZeroDaHero\Normalizer;
use ZeroDaHero\Address;
use ZeroDaHero\SimpleAddress;

class NormalizerTest extends TestCase
{
    /** @test */
    public function testReturnsAddressClass()
    {
        $normalizer = new Normalizer();
        $address = $normalizer->parse('1234 Main St SE, Minneapolis, MN 55401');

        $this->assertInstanceOf(Address::class, $address);
    }

    /** @test */
    public function testReturnsAddressOnFivePart()
    {
        $normalizer = new Normalizer();
        $address = $normalizer->parseFromComponents('1234 Main St SE', null, 'Minneapolis', 'MN', '55401');

        $this->assertInstanceOf(Address::class, $address);
    }

    /** @test */
    public function testReturnsSimpleAddressOnBadFivePart()
    {
        $normalizer = new Normalizer(['strict_mode' => false]);
        $address = $normalizer->parseFromComponents('1234 Main St SE, Unit 301 Unit 301', null, 'Minneapolis,', 'MN,', '55401');

        $this->assertInstanceOf(SimpleAddress::class, $address);
    }

    /** @test */
    public function testReturnsFalseOnBadFivePartStrict()
    {
        $normalizer = new Normalizer(['strict_mode' => true]);
        $address = $normalizer->parseFromComponents('1234 Main St SE, Unit 301 Unit 301', null, 'Minneapolis,', 'MN,', '55401');

        $this->assertFalse($address);
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

    public function badAddressesDataProvider()
    {
        return [
            'double unit no commas' => ['1234 Main St. SE Unit 101 Unit 101'],
            'double unit mismatch comma' => ['1234 Main St. SE, Unit 101 Apt 101, Minneapolis, MN 55555'],
            'double unit comma' => ['3333 West End Ave, Unit 301 Unit 301, Nashville, TN, 37205'],
            'nonsense' => ['Main Street West Fork Soup Salad'],
        ];
    }

    /**
     * @test
     * @dataProvider badAddressesDataProvider
     */
    public function testFailsOnBadAddresses($badAddress)
    {
        $normalizer = new Normalizer();

        $this->assertFalse($normalizer->parse($badAddress));
    }
}
