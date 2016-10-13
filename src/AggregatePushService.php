<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Exception\UnsupportedPushMessageSubscription;
use Psr\Http\Message\RequestInterface;

class AggregatePushService implements PushService
{
    /**
     * @var PushServiceRegistry
     */
    private $pushServiceRegistry;

    /**
     * Constructor.
     *
     * @param PushServiceRegistry $registry
     */
    public function __construct(PushServiceRegistry $registry)
    {
        $this->pushServiceRegistry = $registry;
    }

    /**
     * Check weather this push service supports a certain host.
     *
     * @param string $host
     *
     * @return bool
     */
    public function supportsHost(string $host) : bool
    {
        $pushService = $this->pushServiceRegistry->getPushService($host);

        return $pushService instanceof PushService;
    }

    /**
     * Create a push request.
     *
     * @param PushMessage $message
     *
     * @return RequestInterface
     *
     * @throws UnsupportedPushMessageSubscription When the PushMessage Subscription has an unsupported endpoint.
     */
    public function createRequest(PushMessage $message) : RequestInterface
    {
        $host = $message->getPushSubscription()->getEndpoint()->getHost();

        if (!$this->supportsHost($host)) {
            throw UnsupportedPushMessageSubscription::forHost($host);
        }

        $pushService = $this->pushServiceRegistry->getPushService($host);

        return $pushService->createRequest($message);
    }
}
