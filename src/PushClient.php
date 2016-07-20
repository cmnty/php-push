<?php declare(strict_types = 1);

namespace Cmnty\Push;

interface PushClient
{
    /**
     * Send a push notification.
     *
     * @param PushNotification $notification
     * @param PushSubscription $subscription
     */
    public function pushNotification(PushNotification $notification, PushSubscription $subscription);
}
