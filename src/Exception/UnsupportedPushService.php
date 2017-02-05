<?php declare(strict_types = 1);

namespace Cmnty\Push\Exception;

use Exception;

class UnsupportedPushService extends Exception
{
    /**
     * Create an exception for a given host.
     *
     * @param string $host
     *
     * @return UnsupportedPushService
     */
    public static function forHost($host): UnsupportedPushService
    {
        return new static("The provided push service ($host) is not supported. You can add support by writing your own Cmnty\Push\PushService.");
    }
}
