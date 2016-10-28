<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Endpoint;
use Cmnty\Push\GooglePushService;
use Cmnty\Push\PushMessage;
use Cmnty\Push\PushService;
use Cmnty\Push\PushSubscription;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class GooglePushServiceSpec extends ObjectBehavior
{
    function let(PushMessage $message, PushSubscription $subscription, Endpoint $endpoint)
    {
        $this->beConstructedWith('API_Key');

        $message->getPushSubscription()->willReturn($subscription);

        $message->getBody()->willReturn('cipher_text');
        $message->getContentLength()->willReturn(256);
        $message->getSalt()->willReturn('salt');
        $message->getCryptoKey()->willReturn('key');
        $message->getTTL()->willReturn(3600);

        $subscription->getEndpoint()->willReturn($endpoint);

        $endpoint->getRegistrationId()->willReturn('registration_id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GooglePushService::class);
    }

    function it_should_implement_push_service()
    {
        $this->shouldImplement(PushService::class);
    }

    function it_should_confirm_google_is_supported()
    {
        $this->supportsHost('android.googleapis.com')->shouldReturn(true);
    }

    function it_should_create_a_request_from_a_message(PushMessage $message)
    {
        $this->createRequest($message)->shouldReturnAnInstanceOf(RequestInterface::class);
    }
}
