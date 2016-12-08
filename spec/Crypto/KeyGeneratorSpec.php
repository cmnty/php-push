<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\KeyGenerator;
use Cmnty\Push\Crypto\KeyPair;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KeyGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(KeyGenerator::class);
    }

    function it_should_generate_key_pairs()
    {
        $this->generateKeyPair()->shouldReturnAnInstanceOf(KeyPair::class);
    }
}
