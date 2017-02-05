<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Endpoint;
use Cmnty\Push\MozillaPushService;
use Cmnty\Push\PushMessage;
use Cmnty\Push\PushService;
use Cmnty\Push\PushSubscription;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class MozillaPushServiceSpec extends ObjectBehavior
{
    function let(PushMessage $message)
    {
        $message->getEndpointUrl()->willReturn('https:://mozilla.push.services');

        $message->getBody()->willReturn('cipher_text');
        $message->getContentLength()->willReturn(256);
        $message->getSalt()->willReturn('salt');
        $message->getCryptoKey()->willReturn('key');
        $message->getTTL()->willReturn(3600);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MozillaPushService::class);
    }

    function it_should_implement_push_service()
    {
        $this->shouldImplement(PushService::class);
    }

    function it_should_confirm_mozilla_is_supported()
    {
        $this->supportsHost('updates.push.services.mozilla.com')->shouldReturn(true);
    }

    function it_should_create_a_request_from_a_message(PushMessage $message)
    {
        $this->createRequest($message)->shouldReturnAnInstanceOf(RequestInterface::class);
    }
}
