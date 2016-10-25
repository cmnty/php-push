<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Exception\UnsupportedPushService;

class PushServiceRegistry
{
    /**
     * @var PushService[]
     */
    private $pushServices = [];

    /**
     * Add a push service to the registry.
     *
     * @param PushService $pushService
     */
    public function addPushService(PushService $pushService)
    {
        $this->pushServices[] = $pushService;
    }

    /**
     * Check whether a push service exists in the registry.
     *
     * @param string $host
     *
     * @return bool
     */
    public function hasPushService($host) : bool
    {
        foreach ($this->pushServices as $pushService) {
            if ($pushService->supportsHost($host)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a push service from the registry.
     *
     * @param string $host
     *
     * @return PushService
     *
     * @throws UnsupportedPushService When no push service that supports the given host is found.
     */
    public function getPushService($host) : PushService
    {
        foreach ($this->pushServices as $pushService) {
            if ($pushService->supportsHost($host)) {
                return $pushService;
            }
        }

        throw UnsupportedPushService::forHost($host);
    }
}
