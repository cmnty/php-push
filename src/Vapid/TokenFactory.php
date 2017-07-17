<?php declare(strict_types = 1);

namespace Cmnty\Push\Vapid;

use Cmnty\Push\PushMessage;

interface TokenFactory
{
    /**
     * Create a JWT for a given push message.
     *
     * @param PushMessage $message
     *
     * @return Token
     */
    public function createToken(PushMessage $message): Token;
}
