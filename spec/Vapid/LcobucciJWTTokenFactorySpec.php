<?php

namespace spec\Cmnty\Push\Vapid;

use Cmnty\Push\Crypto\KeyPair;
use Cmnty\Push\Crypto\PrivateKey;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\PushMessage;
use Cmnty\Push\Vapid\LcobucciJWTTokenFactory;
use Cmnty\Push\Vapid\Token;
use Cmnty\Push\Vapid\TokenFactory;
use PhpSpec\ObjectBehavior;

class LcobucciJWTTokenFactorySpec extends ObjectBehavior
{
    function let(KeyPair $keyPair, PrivateKey $privateKey, PublicKey $publicKey)
    {
        $keyPair->getPrivateKey()->willReturn($privateKey);
        $keyPair->getPublicKey()->willReturn($publicKey);

        $testKey = <<<ES256
-----BEGIN EC PRIVATE KEY-----
MHcCAQEEIEsP542fnbo3TNRiUqECa9x1M6UfdOyr2Fyb4qZoW6iUoAoGCCqGSM49
AwEHoUQDQgAEUcDxhEw3zo0RIrn1BqEg9p9qrn917bLjFEOuIGQlKXrOCLIO7QLQ
B7tWdxyLgAIq/yEYUoU4Lbp3rCxOWAYdIg==
-----END EC PRIVATE KEY-----
ES256;

        $privateKey->toPem()->willReturn($testKey);

        $this->beConstructedWith($keyPair, 'mailto:johan@cmnty.com');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LcobucciJWTTokenFactory::class);
    }

    function it_should_implement_push_service()
    {
        $this->shouldImplement(TokenFactory::class);
    }

    function it_should_create_a_token_from_a_message(PushMessage $message)
    {
        $message->getEndpointSchemeAndHost()->willReturn('https://updates.push.services.mozilla.com');

        $this->createToken($message)->shouldReturnAnInstanceOf(Token::class);
    }
}
