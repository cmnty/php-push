<?php declare(strict_types = 1);

namespace Cmnty\Push;

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
     * Get a push service from the registry.
     *
     * @param string $host
     *
     * @return PushService
     */
    public function getPushService($host)
    {
        foreach ($this->pushServices as $pushService) {
            if ($pushService->supportsHost($host)) {
                return $pushService;
            }
        }
    }
}
