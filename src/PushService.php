<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Psr\Http\Message\RequestInterface;

interface PushService
{
    /**
     * Check weather this push service supports a certain host.
     *
     * @param string $host
     *
     * @return bool
     */
    public function supportsHost($host);

    /**
     * Create a push request.
     *
     * @param PushMessage $message
     *
     * @return RequestInterface
     */
    public function createRequest(PushMessage $message);
}
