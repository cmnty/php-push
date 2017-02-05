<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Exception\UnsupportedPushService;
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
    public function supportsHost(string $host): bool
    {
        return $this->pushServiceRegistry->hasPushService($host);
    }

    /**
     * Create a push request.
     *
     * @param PushMessage $message
     *
     * @return RequestInterface
     *
     * @throws UnsupportedPushService When no push service that supports the given push message is found.
     */
    public function createRequest(PushMessage $message): RequestInterface
    {
        $host = $message->getPushSubscription()->getEndpoint()->getHost();
        $pushService = $this->pushServiceRegistry->getPushService($host);

        return $pushService->createRequest($message);
    }
}
