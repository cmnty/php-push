<?php declare(strict_types = 1);

namespace Cmnty\Push;

class Endpoint
{
    /**
     * @var string
     */
    private $url;

    /**
     * Constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the host.
     *
     * @return string
     */
    public function getHost()
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    /**
     * Get the keys.
     *
     * @return string
     */
    public function getRegistrationId()
    {
        preg_match('{^(\S+)(?:/)(?P<registrationId>[^/]+)}', $this->url, $matches);

        return $matches['registrationId'];
    }
}
