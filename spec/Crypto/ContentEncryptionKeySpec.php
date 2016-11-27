<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\ContentEncryptionKey;
use Cmnty\Push\Crypto\KeyingMaterial;
use PhpSpec\ObjectBehavior;

class ContentEncryptionKeySpec extends ObjectBehavior
{
    function let(BinaryString $binaryString)
    {
        $this->beConstructedWith($binaryString);

        $binaryString->getRawBytes()->willReturn('raw_bytes');
        $binaryString->getLength()->willReturn(16);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ContentEncryptionKey::class);
    }

    function it_should_implement_keying_material()
    {
        $this->shouldImplement(KeyingMaterial::class);
    }

    function it_should_contain_the_raw_key_material()
    {
        $this->getRawKeyMaterial()->shouldBeString();
    }

    function it_should_throw_an_exception_if_the_content_encryption_key_has_an_invalid_length(BinaryString $binaryString)
    {
        $binaryString->getLength()->willReturn(15);
        $this->shouldThrow('InvalidArgumentException')->duringInstantiation();
    }
}
