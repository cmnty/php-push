<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\KeyPair;
use Cmnty\Push\Crypto\PrivateKey;
use Cmnty\Push\Crypto\PublicKey;
use PhpSpec\ObjectBehavior;

class KeyPairSpec extends ObjectBehavior
{
    function let(PrivateKey $privateKey, PublicKey $publicKey)
    {
        $privateKey->getPublicKey()->willReturn($publicKey);

        $this->beConstructedWith($privateKey, $publicKey);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(KeyPair::class);
    }

    function it_should_contain_a_private_key()
    {
        $this->getPrivateKey()->shouldReturnAnInstanceOf(PrivateKey::class);
    }

    function it_should_contain_a_public_key()
    {
        $this->getPublicKey()->shouldReturnAnInstanceOf(PublicKey::class);
    }
}
