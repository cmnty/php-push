<?php declare(strict_types = 1);

namespace Cmnty\Push;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class MozillaPushService implements PushService
{
    /**
     * Check weather this push service supports a certain host.
     *
     * @param string $host
     *
     * @return bool
     */
    public function supportsHost(string $host): bool
    {
        return in_array($host, [
            'updates.push.services.mozilla.com',
        ]);
    }

    /**
     * Create a push request.
     *
     * @param PushMessage $message
     *
     * @return RequestInterface
     */
    public function createRequest(PushMessage $message): RequestInterface
    {
        $request = new Request(
            'POST',
            $this->getUrl($message),
            $this->getHeaders($message),
            $this->getBody($message)
        );

        return $request;
    }

    /**
     * Get the request url
     *
     * @param PushMessage $message
     *
     * @return string
     */
    private function getUrl(PushMessage $message): string
    {
        return $message->getPushSubscription()->getEndpoint()->getUrl();
    }

    /**
     * Get the request headers
     *
     * @param PushMessage $message
     *
     * @return string[]
     */
    private function getHeaders(PushMessage $message): array
    {
        return [
            'Content-Type' => 'application/json',
            'Content-Length' => $message->getContentLength(),
            'Encryption' => 'keyid=p256dh;salt='.$message->getSalt(),
            'Crypto-Key' => 'keyid=p256dh;dh='.$message->getCryptoKey(),
            'Content-Encoding' => 'aesgcm',
            'TTL' => $message->getTTL(),
        ];
    }

    /**
     * Get the request body
     *
     * @param PushMessage $message
     *
     * @return string
     */
    private function getBody(PushMessage $message): string
    {
        return $message->getBody();
    }
}
