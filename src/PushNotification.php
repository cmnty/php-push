<?php declare(strict_types = 1);

namespace Cmnty\Push;

interface PushNotification
{
    /**
     * Convert the push notification into a json string.
     *
     * @return string
     */
    public function __toString();

    /**
     * Convert the push notification into a json string.
     *
     * @return string
     */
    public function json(): string;

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Get the body.
     *
     * @return string
     */
    public function getBody(): string;

    /**
     * Get the body.
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Get the icon.
     *
     * @return string|null
     */
    public function getIcon();
}
