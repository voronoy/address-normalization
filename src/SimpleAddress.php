<?php

namespace ZeroDaHero;

use ZeroDaHero\Address;
use ZeroDaHero\Exceptions\AddressNotNormalizedException;

/**
 * This is a non-normalized version of Address::class to make use of hashing.
 */
class SimpleAddress extends Address
{
    protected $address1;
    protected $address2;

    public function __construct(
        string $address1,
        ?string $address2 = null,
        string $city,
        string $state,
        ?string $postalCode = null
    ) {
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalCode;
    }

    /**
     * @inheritDoc
     */
    protected function getLineOne(): string
    {
        if (empty($this->address2)) {
            return $this->address1;
        }
        return $this->address1 . ' ' . $this->address2;
    }

    /**
     * @inheritDoc
     */
    public function getStreetHash(string $algo = 'sha1'): string
    {
        throw new AddressNotNormalizedException('Address is not normalized and cannot hash the street.');
    }
}
