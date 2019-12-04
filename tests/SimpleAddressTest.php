<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZeroDaHero\Exceptions\AddressNotNormalizedException;
use ZeroDaHero\Normalizer;
use ZeroDaHero\SimpleAddress;

class SimpleAddressTest extends TestCase
{
    /** @test */
    public function testHashesAddress()
    {
        // NOTE: this is the normalized version of the address used in AddressTest
        $address = new SimpleAddress('1234 Main St NE', null, 'Minneapolis', 'MN', '55401');

        $this->assertEquals('9bdbf17a475a0129c0546fc210ef46cb914338d0', $address->getHash());
        $this->assertEquals('c4ced80b9489911b4a66712470833242597aa032', $address->getFullHash());

        $this->expectException(AddressNotNormalizedException::class);
        $address->getStreetHash();
    }
}
