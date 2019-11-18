# Basic Address Normalizer

## Purpose

The main purpose of this package is as the first layer of address normalization and standardization. Recommended use is to pre-parse/normalize an address and compare to an existing cache/record set using the hash functions

A way to normalize US mailing addresses without the need for an external service. This is a port of the perl module Geo::StreetAddress::US originally written by Schuyler D. Erle.

This is a fork from khartnett/address-normalization -- kudos for the original work!

## Installation

`composer require zerodahero/address-normalization`

## Usage

### Normalizing

```php
<?php
use ZeroDaHero\Normalizer;
$normalizer = new Normalizer();

// This returns a \ZeroDaHero\Address object with the parsed components
$address = $normalizer->parse('204 southeast Smith Street Harrisburg, or 97446');

$address->getAddressComponents();
/* output:
[
    "number" => "204",
    "street" => "Smith",
    "street_type" => "St",
    "unit" => "",
    "unit_prefix" => "",
    "suffix" => "",
    "prefix" => "SE",
    "city" => "Harrisburg",
    "state" => "OR",
    "postal_code" => "97446",
    "postal_code_ext" => null,
    "street_type2" => null,
    "prefix2" => null,
    "suffix2" => null,
    "street2" => null,
] */

$address->toString();
/* string_result:
"204 SE Smith St, Harrisburg, OR 97446"
*/
```

### Comparing

```php
<?php
use ZeroDaHero\Normalizer;
$normalizer = new Normalizer();

$address1 = $normalizer->parse('204 southeast Smith Street Harrisburg, or 97446');
$address2 = $normalizer->parse('204 SE Smith St. Harrisburg, Oregon 97446');
// Same street, different number
$address3 = $normalizer->parse('207 SE Smith St. Harrisburg, Oregon 97446');

$address1->is($address2); // true
$address2->is($address3); // false
$address1->isSameStreet($address3); // true

// or can compare hashes directly
$address1->getFullHash() === $address2->getFullHash(); // true
```

### Formatting

```php
<?php
use ZeroDaHero\Normalizer;
$normalizer = new Normalizer();

$address = $normalizer->parse('204 southeast Smith Street Harrisburg, or 97446');

$address->toString();
// or
(string) $address;
/* string:
  "204 SE Smith St, Harrisburg, OR 97446"
*/

$address->toArray();
/* array:
  [
    '204 SE Smith St',
    'Harrisburg, OR 97446'
  ]
```