<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Endpoint;
use PhpSpec\ObjectBehavior;

class EndpointSpec extends ObjectBehavior
{
    const URL = 'https://example.com/push-service/send/dbDqU8xX10w:APA91b...';

    function let()
    {
        $this->beConstructedWith(self::URL);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Endpoint::class);
    }

    function it_should_contain_the_full_url()
    {
        $this->getUrl()->shouldReturn(self::URL);
    }

    function it_should_be_able_to_extract_the_scheme_and_host()
    {
        $this->getSchemeAndHost()->shouldReturn('https://example.com');
    }

    function it_should_be_able_to_extract_the_registration_id()
    {
        $this->getRegistrationId()->shouldReturn('dbDqU8xX10w:APA91b...');
    }
}
