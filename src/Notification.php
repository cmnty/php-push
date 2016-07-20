<?php declare(strict_types = 1);

namespace Cmnty\Push;

class Notification implements PushNotification
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $body
     */
    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Convert the push notification into a json string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->json();
    }

    /**
     * Convert the push notification into a json string.
     *
     * @return string
     */
    public function json()
    {
        return json_encode([
            'title' => $this->title,
            'body' => $this->body,
        ]);
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
