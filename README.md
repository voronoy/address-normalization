**Purpose**

A way to normalize US mailing addresses without the need for an external service. This is a port of the perl module Geo::StreetAddress::US originally written by Schuyler D. Erle.

This is a fork from khartnett/address-normalization -- kudos for the original work!

**Installation**

`$composer require zerodahero/address-normalization`

**Usage**

```
<?php
 use ZeroDaHero\Normalizer;
 $n = new Normalizer();
 $address = $n->parse('204 southeast Smith Street Harrisburg, or 97446');
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