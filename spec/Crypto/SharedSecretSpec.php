<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\KeyingMaterial;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Crypto\SharedSecret;
use PhpSpec\ObjectBehavior;

class SharedSecretSpec extends ObjectBehavior
{
    function let(BinaryString $binaryString, PublicKey $recipientPublicKey, PublicKey $senderPublicKey)
    {
        $this->beConstructedWith($binaryString, $recipientPublicKey, $senderPublicKey);

        $binaryString->getRawBytes()->willReturn('raw_bytes');
        $binaryString->getLength()->willReturn(32);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SharedSecret::class);
    }

    function it_should_implement_keying_material()
    {
        $this->shouldImplement(KeyingMaterial::class);
    }

    function it_should_contain_the_raw_key_material()
    {
        $this->getRawKeyMaterial()->shouldBeString();
    }

    function it_should_throw_an_exception_if_the_shared_secret_has_an_invalid_length(BinaryString $binaryString)
    {
        $binaryString->getLength()->willReturn(31);
        $this->shouldThrow('InvalidArgumentException')->duringInstantiation();
    }
}
