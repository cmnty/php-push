<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\AggregatePushService;
use Cmnty\Push\Endpoint;
use Cmnty\Push\PushMessage;
use Cmnty\Push\PushService;
use Cmnty\Push\PushServiceRegistry;
use Cmnty\Push\PushSubscription;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class AggregatePushServiceSpec extends ObjectBehavior
{
    function let(PushServiceRegistry $registry, Endpoint $endpoint, PushService $service, PushMessage $message, RequestInterface $request)
    {
        $this->beConstructedWith($registry);

        $endpoint->getUrl()->willReturn('https://example.org');

        $registry->hasPushService($endpoint)->willReturn(true);
        $registry->getPushService($endpoint)->willReturn($service);

        $service->createRequest($message)->willReturn($request);

        $message->getEndpoint()->willReturn($endpoint);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AggregatePushService::class);
    }

    function it_should_implement_push_service()
    {
        $this->shouldImplement(PushService::class);
    }

    function it_should_confirm_an_endpoint_is_supported(Endpoint $endpoint)
    {
        $this->supportsEndpoint($endpoint)->shouldReturn(true);
    }

    function it_should_create_a_request_from_a_message(PushMessage $message, RequestInterface $request)
    {
        $this->createRequest($message)->shouldReturn($request);
    }
}
