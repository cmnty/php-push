<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Notification;
use Cmnty\Push\PushNotification;
use PhpSpec\ObjectBehavior;

class NotificationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('title', 'body', 'url', 'icon');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Notification::class);
    }

    function it_implements_push_notification_interface()
    {
        $this->shouldImplement(PushNotification::class);
    }

    function it_should_contain_a_title()
    {
        $this->getTitle()->shouldReturn('title');
    }

    function it_throws_an_error_when_no_title_is_supplied()
    {
        $this->beConstructedWith();
        $this->shouldThrow('TypeError')->duringInstantiation();
    }

    function it_should_contain_a_body()
    {
        $this->getBody()->shouldReturn('body');
    }

    function it_throws_an_error_when_no_body_is_supplied()
    {
        $this->beConstructedWith('title');
        $this->shouldThrow('TypeError')->duringInstantiation();
    }

    function it_can_contain_a_url()
    {
        $this->getUrl()->shouldReturn('url');
    }

    function it_does_not_have_to_contain_a_url()
    {
        $this->beConstructedWith('title', 'body');
        $this->getUrl()->shouldReturn(null);
    }

    function it_can_contain_an_icon()
    {
        $this->getIcon()->shouldReturn('icon');
    }

    function it_does_not_have_to_contain_an_icon()
    {
        $this->beConstructedWith('title', 'body');
        $this->getIcon()->shouldReturn(null);
    }

    function it_should_be_able_to_serialize_to_json()
    {
        $this->json()->shouldReturn('{"title":"title","body":"body","url":"url","icon":"icon"}');
    }
}
