<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Psr\Http\Message\ResponseInterface;

interface PushClient
{
    /**
     * Send a push notification.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     *
     * @return ResponseInterface
     */
    public function pushNotification(PushNotification $notification, PushSubscription $subscription);
}
