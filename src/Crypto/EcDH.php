<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Mdanter\Ecc\Crypto\EcDH\EcDH as CoreEcDH;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Math\GmpMathInterface;

class EcDH
{
    /**
     * Adapter used for math calculations
     *
     * @var GmpMathInterface
     */
    private $math;

    /**
     * Initialize a new exchange from a generator point.
     *
     * @param GmpMathInterface $math A gmp math instance.
     */
    public function __construct(GmpMathInterface $math)
    {
        $this->math = $math;
    }

    /**
     * Calculate a shared secret from the servers private key and the users public key.
     *
     * @param PrivateKeyInterface $senderPrivateKey
     * @param PublicKeyInterface  $recipientPublicKey
     *
     * @return string
     */
    public function calculateSharedSecret(PrivateKeyInterface $senderPrivateKey, PublicKeyInterface $recipientPublicKey)
    {
        $ecdh = new CoreEcDH($this->math);
        $ecdh->setSenderKey($senderPrivateKey);
        $ecdh->setRecipientKey($recipientPublicKey);

        $sharedKey = $this->math->toString($ecdh->calculateSharedKey());

        return hex2bin($this->math->decHex($sharedKey));
    }
}
