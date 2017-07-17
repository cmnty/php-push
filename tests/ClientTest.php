<?php declare(strict_types = 1);

namespace Cmnty\Push\Tests;

use Cmnty\Push\Client;
use Cmnty\Push\Crypto\AuthenticationSecret;
use Cmnty\Push\Crypto\KeyPair;
use Cmnty\Push\Crypto\PrivateKey;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\EndPoint;
use Cmnty\Push\Notification;
use Cmnty\Push\Subscription;
use Cmnty\Push\GooglePushService;
use Cmnty\Push\MozillaPushService;
use Cmnty\Push\VapidPushService;
use Cmnty\Push\Vapid\LcobucciJWTTokenFactory;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function setUp()
    {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();
    }

    public function testMozillaPushService()
    {
        $notification = new Notification('Hello Mozilla!', 'This is a test message.');

        $data = json_decode(getenv('MOZILLA_V1'), true);
        $subscription = new Subscription(
            new Endpoint($data['endpoint']),
            PublicKey::createFromBase64UrlEncodedString($data['keys']['p256dh']),
            AuthenticationSecret::createFromBase64UrlEncodedString($data['keys']['auth'])
        );

        $pushService = new MozillaPushService();
        $client = new Client($pushService);

        $response = $client->pushNotification($notification, $subscription);

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testGooglePushService()
    {
        $notification = new Notification('Hello Google!', 'This is a test message.');

        $data = json_decode(getenv('GOOGLE_GCM'), true);
        $subscription = new Subscription(
            new Endpoint($data['endpoint']),
            PublicKey::createFromBase64UrlEncodedString($data['keys']['p256dh']),
            AuthenticationSecret::createFromBase64UrlEncodedString($data['keys']['auth'])
        );

        $pushService = new GooglePushService(getenv('GCM_SENDER_ID'));
        $client = new Client($pushService);

        $response = $client->pushNotification($notification, $subscription);

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testVapidPushServiceWithMozilla()
    {
        $notification = new Notification('Hello Mozilla!', '[VAPID] This is a test message.');

        $data = json_decode(getenv('MOZILLA_V2'), true);
        $subscription = new Subscription(
            new Endpoint($data['endpoint']),
            PublicKey::createFromBase64UrlEncodedString($data['keys']['p256dh']),
            AuthenticationSecret::createFromBase64UrlEncodedString($data['keys']['auth'])
        );

        $privateKey = PrivateKey::createFromPem(file_get_contents(getenv('VAPID_PRIVATE_KEY')));
        $publicKey = PublicKey::createFromPem(file_get_contents(getenv('VAPID_PUBLIC_KEY')));

        $keyPair = new KeyPair($privateKey, $publicKey);

        $tokenFactory = new LcobucciJWTTokenFactory($keyPair, 'mailto:johan@cmnty.com');
        $pushService = new VapidPushService($tokenFactory);
        $client = new Client($pushService);

        $response = $client->pushNotification($notification, $subscription);

        $this->assertSame(201, $response->getStatusCode());
    }

    public function testVapidPushServiceWithGoogle()
    {
        $notification = new Notification('Hello Google!', '[VAPID] This is a test message.');

        $data = json_decode(getenv('GOOGLE_FCM'), true);
        $subscription = new Subscription(
            new Endpoint($data['endpoint']),
            PublicKey::createFromBase64UrlEncodedString($data['keys']['p256dh']),
            AuthenticationSecret::createFromBase64UrlEncodedString($data['keys']['auth'])
        );

        $privateKey = PrivateKey::createFromPem(file_get_contents(getenv('VAPID_PRIVATE_KEY')));
        $publicKey = PublicKey::createFromPem(file_get_contents(getenv('VAPID_PUBLIC_KEY')));

        $keyPair = new KeyPair($privateKey, $publicKey);

        $tokenFactory = new LcobucciJWTTokenFactory($keyPair, 'mailto:johan@cmnty.com');
        $pushService = new VapidPushService($tokenFactory);
        $client = new Client($pushService);

        $response = $client->pushNotification($notification, $subscription);

        $this->assertSame(201, $response->getStatusCode());
    }
}
