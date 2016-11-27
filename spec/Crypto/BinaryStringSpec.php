<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\RawBytes;
use PhpSpec\ObjectBehavior;

class BinaryStringSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('raw_bytes');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BinaryString::class);
    }

    function it_should_implement_raw_bytes()
    {
        $this->shouldImplement(RawBytes::class);
    }

    function it_should_contain_the_raw_bytes()
    {
        $this->getRawBytes()->shouldBeString();
    }

    function it_should_contain_a_base64url_encoded_version_of_the_raw_bytes()
    {
        $this->getBase64UrlEncodedString()->shouldBeString();
    }

    function it_should_know_its_length()
    {
        $this->getLength()->shouldBeInt();
    }

    function it_should_be_able_to_concatenate_itself_with_another_binary_string(BinaryString $binaryString)
    {
        $binaryString->getRawBytes()->willReturn('more_raw_bytes');

        $this->concat($binaryString)->shouldReturnAnInstanceOf(BinaryString::class);
    }

    function it_should_be_able_to_slice_itself_to_a_certain_length()
    {
        $this->slice(16)->shouldReturnAnInstanceOf(BinaryString::class);
    }
}
