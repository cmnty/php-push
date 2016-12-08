<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\CipherText;
use Cmnty\Push\Crypto\RawBytes;
use PhpSpec\ObjectBehavior;

class CipherTextSpec extends ObjectBehavior
{
    function let(BinaryString $binaryString)
    {
        $this->beConstructedWith($binaryString);

        $binaryString->getRawBytes()->willReturn('raw_bytes');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CipherText::class);
    }

    function it_should_implement_raw_bytes()
    {
        $this->shouldImplement(RawBytes::class);
    }

    function it_should_contain_the_raw_bytes()
    {
        $this->getRawBytes()->shouldBeString();
    }
}
