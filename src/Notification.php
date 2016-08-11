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
     * @var string|null
     */
    private $url;

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $body
     * @param string|null $url
     */
    public function __construct($title, $body, $url = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
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
            'url' => $this->url,
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

    /**
     * Get the url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }
}
