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
     * @param Endpoint $endpoint
     *
     * @return bool
     */
    public function hasPushService(Endpoint $endpoint): bool
    {
        foreach ($this->pushServices as $pushService) {
            if ($pushService->supportsEndpoint($endpoint)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a push service from the registry.
     *
     * @param Endpoint $endpoint
     *
     * @return PushService
     *
     * @throws UnsupportedPushService When no push service that supports the given endpoint is found.
     */
    public function getPushService(Endpoint $endpoint): PushService
    {
        foreach ($this->pushServices as $pushService) {
            if ($pushService->supportsEndpoint($endpoint)) {
                return $pushService;
            }
        }

        throw UnsupportedPushService::forEndpoint($endpoint);
    }
}
