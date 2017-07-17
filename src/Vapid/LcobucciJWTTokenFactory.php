<?php declare(strict_types = 1);

namespace Cmnty\Push\Vapid;

use Cmnty\Push\Crypto\KeyPair;
use Cmnty\Push\PushMessage;
use JDR\JWS\ECDSA\ES256;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;

class LcobucciJWTTokenFactory implements TokenFactory
{
    /**
     * @var KeyPair
     */
    private $keyPair;

    /**
     * @var string
     */
    private $subject;

    /**
     * Constructor.
     *
     * @param KeyPair $keyPair
     * @param string $subject
     */
    public function __construct(KeyPair $keyPair, string $subject)
    {
        $this->keyPair = $keyPair;
        $this->subject = $subject;
    }

    /**
     * Create a JWT for a given push message.
     *
     * @param PushMessage $message
     *
     * @return Token
     */
    public function createToken(PushMessage $message): Token
    {
        $token = (new Builder())
            ->setAudience($message->getEndpointSchemeAndHost())
            ->setIssuedAt(time())
            ->setExpiration(time() + 3600)
            ->setSubject($this->subject)
            ->sign(new ES256(), new Key($this->keyPair->getPrivateKey()->toPem()))
            ->getToken();

        return new Token((string) $token, $this->keyPair->getPublicKey());
    }
}
