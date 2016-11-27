<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\AuthenticationSecret;
use Cmnty\Push\Crypto\Cipher;
use Cmnty\Push\Crypto\Cryptograph;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\PushNotification;
use Cmnty\Push\Subscription;
use Mdanter\Ecc\EccFactory;
use PhpSpec\ObjectBehavior;

class CryptographSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Cryptograph::class);
    }

    function it_should_encrypt_a_push_notification(PushNotification $notification, Subscription $subscription)
    {
        $notification->json()->willReturn('{"title":"Here be dragons","body":"Winter is coming"}');

        $key = PublicKey::createFromBase64UrlEncodedString('BEVYVy0G5j5KhryGGTGZNJejRZJRRVa1BLsCFxZQVZBtLFEso1Tkug8Zji3zX7JPoyLzYn7RXMfj3hd6MwLTqsk');
        $secret = AuthenticationSecret::createFromBase64UrlEncodedString('giIO3ijRFJuoDuH1w4DKYg');

        $subscription->getPublicKey()->willReturn($key);
        $subscription->getAuthenticationSecret()->willReturn($secret);

        $this->encrypt($notification, $subscription)->shouldReturnAnInstanceOf(Cipher::class);
    }
}
