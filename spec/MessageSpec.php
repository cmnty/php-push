<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Crypto\AuthenticationTag;
use Cmnty\Push\Crypto\Cipher;
use Cmnty\Push\Crypto\CipherText;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Crypto\Salt;
use Cmnty\Push\Message;
use Cmnty\Push\PushMessage;
use Cmnty\Push\PushSubscription;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    function let(Cipher $cipher, PushSubscription $subscription)
    {
        $this->beConstructedWith($cipher, $subscription, 3600);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Message::class);
    }

    function it_should_implement_push_message()
    {
        $this->shouldImplement(PushMessage::class);
    }

    function it_should_contain_the_message_body(Cipher $cipher, CipherText $cipherText, AuthenticationTag $tag)
    {
        $cipher->getCipherText()->willReturn($cipherText);
        $cipherText->getRawBytes()->willReturn('raw_bytes');
        $cipher->getAuthenticationTag()->willReturn($tag);
        $tag->getRawBytes()->willReturn('raw_bytes');

        $this->getBody()->shouldBeString();
    }

    function it_should_contain_the_used_salt(Cipher $cipher, Salt $salt)
    {
        $cipher->getSalt()->willReturn($salt);
        $salt->getBase64UrlEncodedString()->willReturn('base64url');

        $this->getSalt()->shouldBeString();
    }

    function it_should_contain_the_used_public_key(Cipher $cipher, PublicKey $key)
    {
        $cipher->getPublicKey()->willReturn($key);
        $key->getBase64UrlEncodedString()->willReturn('base64url');

        $this->getCryptoKey()->shouldBeString();
    }

    function it_should_contain_the_content_length(Cipher $cipher, CipherText $cipherText, AuthenticationTag $tag)
    {
        $cipher->getCipherText()->willReturn($cipherText);
        $cipherText->getRawBytes()->willReturn('raw_bytes');
        $cipher->getAuthenticationTag()->willReturn($tag);
        $tag->getRawBytes()->willReturn('raw_bytes');

        $this->getContentLength()->shouldBeInt();
    }

    function it_should_contain_a_push_subscription(PushSubscription $subscription)
    {
        $this->getPushSubscription()->shouldReturn($subscription);
    }

    function it_should_contain_the_time_to_live()
    {
        $this->getTTL()->shouldBeInt();
    }
}
