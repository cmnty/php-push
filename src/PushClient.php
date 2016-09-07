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
     * @param int $ttl
     *
     * @return ResponseInterface
     */
    public function pushNotification(PushNotification $notification, PushSubscription $subscription, $ttl = 3600);

    /**
     * Send a push notification asynchronously.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     * @param int $ttl
     *
     * @return PromiseInterface
     */
    public function pushNotificationAsync(PushNotification $notification, PushSubscription $subscription, $ttl = 3600);
}
