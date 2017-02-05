<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Crypto\AuthenticationSecret;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Endpoint;
use Cmnty\Push\PushSubscription;
use Cmnty\Push\Subscription;
use PhpSpec\ObjectBehavior;

class SubscriptionSpec extends ObjectBehavior
{
    function let(Endpoint $endpoint, PublicKey $key, AuthenticationSecret $secret)
    {
        $this->beConstructedWith($endpoint, $key, $secret);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Subscription::class);
    }

    function it_should_implement_push_subscription()
    {
        $this->shouldImplement(PushSubscription::class);
    }

    function it_should_contain_an_endpoint(Endpoint $endpoint)
    {
        $this->getEndpoint()->shouldReturn($endpoint);
    }

    function it_should_contain_the_host_of_the_endpoint(Endpoint $endpoint)
    {
        $endpoint->getHost()->willReturn('host');

        $this->getEndpointHost()->shouldBeString();
    }

    function it_should_contain_the_url_of_the_endpoint(Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://domain.tld');

        $this->getEndpointUrl()->shouldBeString();
    }

    function it_should_contain_the_registration_id_of_the_endpoint(Endpoint $endpoint)
    {
        $endpoint->getRegistrationId()->willReturn('registration_id');

        $this->getEndpointRegistrationId()->shouldBeString();
    }

    function it_should_contain_a_public_key(PublicKey $key)
    {
        $this->getPublicKey()->shouldReturn($key);
    }

    function it_should_contain_an_authentication_secret(AuthenticationSecret $secret)
    {
        $this->getAuthenticationSecret()->shouldReturn($secret);
    }
}
