<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Client;
use Cmnty\Push\PushClient;
use Cmnty\Push\PushService;
use PhpSpec\ObjectBehavior;

class ClientSpec extends ObjectBehavior
{
    function let(PushService $service)
    {
        $this->beConstructedWith($service);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_should_implement_push_client()
    {
        $this->shouldImplement(PushClient::class);
    }
}
