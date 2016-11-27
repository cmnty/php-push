<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\RawBytes;
use Cmnty\Push\Crypto\Salt;
use PhpSpec\ObjectBehavior;

class SaltSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Salt::class);
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
}
