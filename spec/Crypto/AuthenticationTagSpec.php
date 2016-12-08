<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\AuthenticationTag;
use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\RawBytes;
use PhpSpec\ObjectBehavior;

class AuthenticationTagSpec extends ObjectBehavior
{
    function let(BinaryString $binaryString)
    {
        $this->beConstructedWith($binaryString);

        $binaryString->getRawBytes()->willReturn('raw_bytes');
        $binaryString->getLength()->willReturn(16);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthenticationTag::class);
    }

    function it_should_implement_raw_bytes()
    {
        $this->shouldImplement(RawBytes::class);
    }

    function it_should_contain_the_raw_bytes()
    {
        $this->getRawBytes()->shouldBeString();
    }

    function it_should_throw_an_exception_if_the_tag_has_an_invalid_length(BinaryString $binaryString)
    {
        $binaryString->getLength()->willReturn(15);
        $this->shouldThrow('InvalidArgumentException')->duringInstantiation();
    }
}
