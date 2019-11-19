<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZeroDaHero\Normalizer;
use ZeroDaHero\Address;

class AddressTest extends TestCase
{
    /** @test */
    public function testHashesAddress()
    {
        $normalizer = new Normalizer();
        $address = $normalizer->parse("1234 Main St. NE, Minneapolis, MN 55401");
        $sameAddressDiffZip = $normalizer->parse("1234 Main St. NE, Minneapolis, MN 55402");
        $sameAddress = $normalizer->parse("1234 Main Street Northeast, Minneapolis, Minnesota 55401");
        $differentNumberAddress = $normalizer->parse("5678 Main Street Northeast, Minneapolis, Minnesota 55401");

        $this->assertEquals('9bdbf17a475a0129c0546fc210ef46cb914338d0', $address->getHash());
        $this->assertEquals('c4ced80b9489911b4a66712470833242597aa032', $address->getFullHash());
        $this->assertEquals('f7f77f11493cccb50c5827dff7cb8b26d31f8442', $address->getStreetHash());

        $this->assertEquals($address->getHash(), $sameAddressDiffZip->getHash());
        $this->assertNotEquals($address->getFullHash(), $sameAddressDiffZip->getFullHash());

        $this->assertEquals($address->getHash(), $sameAddress->getHash());
        $this->assertEquals($address->getFullHash(), $sameAddress->getFullHash());
        $this->assertEquals($address->getStreetHash(), $sameAddress->getStreetHash());
        $this->assertTrue($address->is($sameAddress));
        $this->assertTrue($sameAddress->is($address));
        $this->assertTrue($address->is($sameAddress, true));
        $this->assertTrue($sameAddress->is($address, true));

        $this->assertEquals($address->getStreetHash(), $differentNumberAddress->getStreetHash());
        $this->assertNotEquals($address->getFullHash(), $differentNumberAddress->getFullHash());
        $this->assertTrue($address->isSameStreet($differentNumberAddress));
        $this->assertTrue($differentNumberAddress->isSameStreet($address));
    }
}
