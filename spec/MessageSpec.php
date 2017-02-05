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

    function it_should_contain_the_message_body(Cipher $cipher)
    {
        $cipher->getRawCipherText()->willReturn('raw_bytes');
        $cipher->getRawAuthenticationTag()->willReturn('raw_bytes');

        $this->getBody()->shouldBeString();
    }

    function it_should_contain_the_used_salt(Cipher $cipher)
    {
        $cipher->getBase64UrlEncodedSalt()->willReturn('base64url');

        $this->getSalt()->shouldBeString();
    }

    function it_should_contain_the_used_public_key(Cipher $cipher)
    {
        $cipher->getBase64UrlEncodedPublicKey()->willReturn('base64url');

        $this->getCryptoKey()->shouldBeString();
    }

    function it_should_contain_the_content_length(Cipher $cipher)
    {
        $cipher->getRawCipherText()->willReturn('raw_bytes');
        $cipher->getRawAuthenticationTag()->willReturn('raw_bytes');

        $this->getContentLength()->shouldBeInt();
    }

    function it_should_contain_a_push_subscription(PushSubscription $subscription)
    {
        $this->getPushSubscription()->shouldReturn($subscription);
    }

    function it_should_contain_the_host_of_the_push_subscription_endpoint(PushSubscription $subscription)
    {
        $subscription->getEndpointHost()->willReturn('host');

        $this->getEndpointHost()->shouldBeString();
    }

    function it_should_contain_the_url_of_the_push_subscription_endpoint(PushSubscription $subscription)
    {
        $subscription->getEndpointUrl()->willReturn('https://domain.tld');

        $this->getEndpointUrl()->shouldBeString();
    }

    function it_should_contain_the_registration_id_of_the_push_subscription_endpoint(PushSubscription $subscription)
    {
        $subscription->getEndpointRegistrationId()->willReturn('registration_id');

        $this->getEndpointRegistrationId()->shouldBeString();
    }

    function it_should_contain_the_time_to_live()
    {
        $this->getTTL()->shouldBeInt();
    }
}
