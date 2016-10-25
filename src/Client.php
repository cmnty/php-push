<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Crypto\Cryptograph;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements PushClient
{
    /**
     * @var PushService
     */
    private $pushService;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var Cryptograph
     */
    private $cryptograph;

    /**
     * Constructor.
     *
     * @param PushService $pushService
     * @param HttpClient $httpClient
     * @param Cryptograph $cryptograph
     */
    public function __construct(PushService $pushService, HttpClient $httpClient = null, Cryptograph $cryptograph = null)
    {
        $this->pushService = $pushService;
        $this->httpClient = $httpClient ?? new HttpClient();
        $this->cryptograph = $cryptograph ?? new Cryptograph();
    }

    /**
     * Send a push notification.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     * @param int $ttl
     *
     * @return ResponseInterface
     */
    public function pushNotification(PushNotification $notification, PushSubscription $subscription, int $ttl = 3600) : ResponseInterface
    {
        return $this->pushNotificationAsync($notification, $subscription, $ttl)->wait();
    }

    /**
     * Send a push notification asynchronously.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     * @param int $ttl
     *
     * @return PromiseInterface
     */
    public function pushNotificationAsync(PushNotification $notification, PushSubscription $subscription, int $ttl = 3600) : PromiseInterface
    {
        $cipher = $this->cryptograph->encrypt($notification, $subscription);

        $pushMessage = new Message($cipher, $subscription, $ttl);

        $request = $this->pushService->createRequest($pushMessage, $subscription);
        $promise = $this->httpClient->sendAsync($request);

        return $promise;
    }
}
