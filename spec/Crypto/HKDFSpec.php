<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\HKDF;
use Cmnty\Push\Crypto\KeyingMaterial;
use Cmnty\Push\Crypto\Salt;
use PhpSpec\ObjectBehavior;

class HKDFSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HKDF::class);
    }

    function it_should_be_callable(Salt $salt, KeyingMaterial $keyingMaterial)
    {
        $salt->getRawBytes()->willReturn('raw_bytes');
        $keyingMaterial->getRawKeyMaterial()->willReturn('raw_key_material');

        $this->__invoke($salt, $keyingMaterial, 'Content-Encoding', 32)->shouldReturnAnInstanceOf(BinaryString::class);
    }
}
