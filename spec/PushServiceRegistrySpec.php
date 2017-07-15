<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Endpoint;
use Cmnty\Push\Exception\UnsupportedPushService;
use Cmnty\Push\PushService;
use Cmnty\Push\PushServiceRegistry;
use PhpSpec\ObjectBehavior;

class PushServiceRegistrySpec extends ObjectBehavior
{
    function let(PushService $service)
    {
        $this->addPushService($service);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PushServiceRegistry::class);
    }

    function it_should_confirm_a_push_service_is_supported(PushService $service, Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://example.org');
        $service->supportsEndpoint($endpoint)->willReturn(true);

        $this->hasPushService($endpoint)->shouldReturn(true);
    }

    function it_should_confirm_a_push_service_is_not_supported(PushService $service, Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://example.com');
        $service->supportsEndpoint($endpoint)->willReturn(false);

        $this->hasPushService($endpoint)->shouldReturn(false);
    }

    function it_should_store_push_services(PushService $service, Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://example.org');
        $service->supportsEndpoint($endpoint)->willReturn(true);

        $this->getPushService($endpoint)->shouldReturn($service);
    }

    function it_should_throw_excepton_when_endpoint_is_not_supported(PushService $service, Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://example.com');
        $service->supportsEndpoint($endpoint)->willReturn(false);

        $this->shouldThrow(UnsupportedPushService::class)->during('getPushService', [$endpoint]);
    }
}
