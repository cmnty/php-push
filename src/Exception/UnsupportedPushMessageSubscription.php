<?php declare(strict_types = 1);

namespace Cmnty\Push\Exception;

use Exception;

class UnsupportedPushMessageSubscription extends Exception
{
    /**
     * Create an exception for a given host.
     *
     * @param string $host
     *
     * @return UnsupportedPushMessageSubscription
     */
    public static function forHost($host)
    {
        return new Exception("The provided host ($host) for the subscription is not supported. You can add support by writing your own Cmnty\Push\PushService.");
    }
}
