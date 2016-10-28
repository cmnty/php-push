<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Exception\UnsupportedPushService;
use Cmnty\Push\PushService;
use Cmnty\Push\PushServiceRegistry;
use PhpSpec\ObjectBehavior;

class PushServiceRegistrySpec extends ObjectBehavior
{
    function let(PushService $service)
    {
        $this->addPushService($service);
        $service->supportsHost('example.com')->willReturn(true);
        $service->supportsHost('example.org')->willReturn(false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PushServiceRegistry::class);
    }

    function it_should_confirm_a_push_service_is_supported()
    {
        $this->hasPushService('example.com')->shouldReturn(true);
    }

    function it_should_confirm_a_push_service_is_not_supported()
    {
        $this->hasPushService('example.org')->shouldReturn(false);
    }

    function it_should_store_push_services(PushService $service)
    {
        $this->getPushService('example.com')->shouldReturn($service);
    }

    function it_should_throw_excepton_when_host_is_not_supported()
    {
        $this->shouldThrow(UnsupportedPushService::class)->during('getPushService', ['example.org']);
    }
}
