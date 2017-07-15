<?php declare(strict_types = 1);

namespace Cmnty\Push\Exception;

use Cmnty\Push\Endpoint;
use Exception;

class UnsupportedPushService extends Exception
{
    /**
     * Create an exception for a given endpoint.
     *
     * @param Endpoint $endpoint
     *
     * @return UnsupportedPushService
     */
    public static function forEndpoint(Endpoint $endpoint): UnsupportedPushService
    {
        $url = $endpoint->getUrl();

        return new static("The provided push service ($url) is not supported. You can add support by writing your own Cmnty\Push\PushService.");
    }
}
