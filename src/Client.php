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
     * Constructor.
     *
     * @param PushService $pushService
     * @param HttpClient $httpClient
     * @param Cryptograph $cryptograph
     */
    public function __construct(PushService $pushService, HttpClient $httpClient = null, Cryptograph $cryptograph = null)
    {
        $this->pushService = $pushService;
        $this->httpClient = $httpClient ?: new HttpClient();
        $this->cryptograph = $cryptograph ?: new Cryptograph();
    }

    /**
     * Send a push notification.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     *
     * @return ResponseInterface
     */
    public function pushNotification(PushNotification $notification, PushSubscription $subscription)
    {
        return $this->pushNotificationAsync($notification, $subscription)->wait();
    }

    /**
     * Send a push notification asynchronously.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     *
     * @return PromiseInterface
     */
    public function pushNotificationAsync(PushNotification $notification, PushSubscription $subscription)
    {
        $cipher = $this->cryptograph->encrypt($notification, $subscription);

        $pushMessage = new Message($cipher, $subscription);

        $request = $this->pushService->createRequest($pushMessage, $subscription);
        $promise = $this->httpClient->sendAsync($request);

        return $promise;
    }
}
