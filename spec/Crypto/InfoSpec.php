<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\Info;
use Cmnty\Push\Crypto\PublicKey;
use PhpSpec\ObjectBehavior;

class InfoSpec extends ObjectBehavior
{
    function let(PublicKey $recipientPublicKey, PublicKey $senderPublicKey)
    {
        $recipientPublicKey->getRawKeyMaterial()->willReturn('raw_key_material');
        $recipientPublicKey->getLength()->willReturn(65);
        $senderPublicKey->getRawKeyMaterial()->willReturn('raw_key_material');
        $senderPublicKey->getLength()->willReturn(65);

        $this->beConstructedWith($recipientPublicKey, $senderPublicKey);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Info::class);
    }

    function it_should_generate_content_encoding_for_auth()
    {
        $this->getContentEncoding('auth')->shouldBeString();
    }

    function it_should_generate_content_encoding_for_content_encryption_key()
    {
        $this->getContentEncoding('aesgcm')->shouldBeString();
    }

    function it_should_generate_content_encoding_for_nonce()
    {
        $this->getContentEncoding('nonce')->shouldBeString();
    }
}
