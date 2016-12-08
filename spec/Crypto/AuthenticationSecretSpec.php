<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\AuthenticationSecret;
use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\RawBytes;
use PhpSpec\ObjectBehavior;

class AuthenticationSecretSpec extends ObjectBehavior
{
    function let(BinaryString $binaryString)
    {
        $this->beConstructedWith($binaryString);

        $binaryString->getRawBytes()->willReturn('raw_bytes');
        $binaryString->getBase64UrlEncodedString()->willReturn('base64url');
        $binaryString->getLength()->willReturn(16);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthenticationSecret::class);
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

    function it_should_throw_an_exception_if_the_secret_has_an_invalid_length(BinaryString $binaryString)
    {
        $binaryString->getLength()->willReturn(15);
        $this->shouldThrow('InvalidArgumentException')->duringInstantiation();
    }

    function it_can_be_created_from_a_base64url_encoded_string()
    {
        $this->beConstructedThrough('createFromBase64UrlEncodedString', [
            'giIO3ijRFJuoDuH1w4DKYg',
        ]);

        $this->shouldHaveType(AuthenticationSecret::class);
    }
}
