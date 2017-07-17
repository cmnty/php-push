<?php

namespace spec\Cmnty\Push;

use Cmnty\Push\Endpoint;
use Cmnty\Push\PushMessage;
use Cmnty\Push\PushService;
use Cmnty\Push\PushSubscription;
use Cmnty\Push\Vapid\Token;
use Cmnty\Push\Vapid\TokenFactory;
use Cmnty\Push\VapidPushService;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class VapidPushServiceSpec extends ObjectBehavior
{
    function let(TokenFactory $tokenFactory)
    {
        $this->beConstructedWith($tokenFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VapidPushService::class);
    }

    function it_should_implement_push_service()
    {
        $this->shouldImplement(PushService::class);
    }

    function it_should_confirm_google_fcm_is_supported(Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://fcm.googleapis.com/fcm/send/...');

        $this->supportsEndpoint($endpoint)->shouldReturn(true);
    }

    function it_should_confirm_mozilla_v2_is_supported(Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://updates.push.services.mozilla.com/wpush/v2/...');

        $this->supportsEndpoint($endpoint)->shouldReturn(true);
    }

    function it_should_confirm_google_gcm_is_not_supported(Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://android.googleapis.com/gcm/send/...');

        $this->supportsEndpoint($endpoint)->shouldReturn(false);
    }

    function it_should_confirm_mozilla_v1_is_not_supported(Endpoint $endpoint)
    {
        $endpoint->getUrl()->willReturn('https://updates.push.services.mozilla.com/wpush/v1/...');

        $this->supportsEndpoint($endpoint)->shouldReturn(false);
    }

    function it_should_create_a_request_from_a_message(PushMessage $message, TokenFactory $tokenFactory, Token $token)
    {
        $tokenFactory->createToken($message)->willReturn($token);

        $token->toString()->willReturn('jwt_token');
        $token->getPublicKeyAsBase64UrlEncodedString()->willReturn('base64url');

        $message->getEndpointUrl()->willReturn('https://updates.push.services.mozilla.com/wpush/v2/...');

        $message->getBody()->willReturn('cipher_text');
        $message->getContentLength()->willReturn(256);
        $message->getSalt()->willReturn('salt');
        $message->getCryptoKey()->willReturn('key');
        $message->getTTL()->willReturn(3600);

        $this->createRequest($message)->shouldReturnAnInstanceOf(RequestInterface::class);
    }
}
