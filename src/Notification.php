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
     * @var string|null
     */
    private $icon;

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $body
     * @param string|null $url
     * @param string|null $icon
     */
    public function __construct(string $title, string $body, string $url = null, string $icon = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
        $this->icon = $icon;
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
    public function json() : string
    {
        return json_encode([
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'icon' => $this->icon,
        ]);
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Get the body.
     *
     * @return string
     */
    public function getBody() : string
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

    /**
     * Get the icon.
     *
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
