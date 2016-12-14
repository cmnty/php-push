<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Cmnty\Push\PushNotification;
use Cmnty\Push\Subscription;

class Cryptograph
{
    /**
     * @var Crypt
     */
    private $crypt;

    /**
     * @var int
     */
    private $length;

    /**
     * Constructor.
     *
     * @param Crypt $length
     * @param int|null $length
     */
    public function __construct(Crypt $crypt, int $length = null)
    {
        $this->crypt = $crypt;
        $this->length = $length ?? 0;
    }

    /**
     * Message encryption
     *
     * @param PushNotification $notification
     * @param Subscription $subscription
     *
     * @return Cipher
     */
    public function encrypt(PushNotification $notification, Subscription $subscription) : Cipher
    {
        $plainText = $this->addPadding($notification->json());

        $recipientPublicKey = $subscription->getPublicKey();
        $authenticationSecret = $subscription->getAuthenticationSecret();

        $generator = new KeyGenerator();
        $keyPair = $generator->generateKeyPair();
        $senderPrivateKey = $keyPair->getPrivateKey();
        $senderPublicKey = $keyPair->getPublicKey();

        $sharedSecret = $senderPrivateKey->calculateSharedSecret($recipientPublicKey);

        $salt = new Salt();
        $info = new Info($recipientPublicKey, $senderPublicKey);
        $hkdf = new HKDF();

        $pseudoRandomKey = new PseudoRandomKey($hkdf($authenticationSecret, $sharedSecret, $info->getContentEncoding('auth'), 32));
        $contentEncryptionKey = new ContentEncryptionKey($hkdf($salt, $pseudoRandomKey, $info->getContentEncoding('aesgcm'), 16));
        $nonce = new Nonce($hkdf($salt, $pseudoRandomKey, $info->getContentEncoding('nonce'), 12));

        return $this->crypt->encrypt($plainText, $contentEncryptionKey, $nonce, $salt, $senderPublicKey);
    }

    /**
     * Add padding.
     *
     * Add padding to the plain text notification. This can be used to hide the length of the message send.
     *
     * @param string $notification
     *
     * @return string
     */
    private function addPadding(string $notification) : string
    {
        $length = $this->length;

        return pack('n*', $length).str_pad($notification, $length + 2, chr(0), STR_PAD_LEFT);
    }
}
