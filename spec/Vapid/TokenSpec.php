<?php

namespace spec\Cmnty\Push\Vapid;

use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Vapid\Token;
use PhpSpec\ObjectBehavior;

class TokenSpec extends ObjectBehavior
{
    function let(PublicKey $publicKey)
    {
        $this->beConstructedWith('jwt_token', $publicKey);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Token::class);
    }

    function it_should_convert_token_to_a_string()
    {
        $this->toString()->shouldReturn('jwt_token');
    }

    function it_should_contain_the_public_key_as_a_base64ul_encoded_string(PublicKey $publicKey)
    {
        $publicKey->getBase64UrlEncodedString()->willReturn('base64url');

        $this->getPublicKeyAsBase64UrlEncodedString()->shouldReturn('base64url');
    }
}
