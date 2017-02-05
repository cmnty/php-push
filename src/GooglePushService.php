<?php declare(strict_types = 1);

namespace Cmnty\Push;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class GooglePushService implements PushService
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * Constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

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
            'android.googleapis.com',
            'fcm.googleapis.com',
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
            $this->getUri($message),
            $this->getHeaders($message),
            $this->getBody($message)
        );

        return $request;
    }

    /**
     * Get the request uri
     *
     * @param PushMessage $message
     *
     * @return string
     */
    private function getUri(PushMessage $message): string
    {
        return 'https://fcm.googleapis.com/fcm/send/'.$message->getPushSubscription()->getEndpoint()->getRegistrationId();
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
            'Authorization' => 'key='.$this->apiKey,
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
     * @param  PushMessage $message
     *
     * @return string
     */
    private function getBody(PushMessage $message): string
    {
        return $message->getBody();
    }
}
