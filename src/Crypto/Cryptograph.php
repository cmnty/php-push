<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Cmnty\Push\PushNotification;
use Cmnty\Push\Subscription;

class Cryptograph
{
    /**
     * @var int
     */
    private $length;

    /**
     * Constructor.
     *
     * @param int $length
     */
    public function __construct($length = null)
    {
        $this->length = $length ?: 0;
    }

    /**
     * Message encryption
     *
     * @param PushNotification $notification
     * @param Subscription $subscription
     *
     * @return Cipher
     */
    public function encrypt(PushNotification $notification, Subscription $subscription)
    {
        $plainText = $this->addPadding((string) $notification);

        $recipientPublicKey = $subscription->getPublicKey();
        $authenticationTag = $subscription->getAuthenticationTag();

        $salt = Salt::createWithLength(16);

        $ikmGenerator = new InitialKeyingMaterialGenerator();
        $ikm = $ikmGenerator->generateInitialKeyingMaterial($recipientPublicKey);
        $senderPublicKey = $ikm->getServerPublicKey();

        $prk = self::hkdf($authenticationTag->getRawBytes(), $ikm->getRawBytes(), 'Content-Encoding: auth'.chr(0), 32);

        $contentEncryptionKeyInfo = new Info('aesgcm', $recipientPublicKey, $senderPublicKey);
        $contentEncryptionKey = self::hkdf($salt->getRawBytes(), $prk, $contentEncryptionKeyInfo->getInfo(), 16);

        $nonceInfo = new Info('nonce', $recipientPublicKey, $senderPublicKey);
        $nonce = self::hkdf($salt->getRawBytes(), $prk, $nonceInfo->getInfo(), 12);

        $cipher = new \Crypto\Cipher('aes-128-gcm');
        $cipherText = new CipherText($cipher->encrypt($plainText, $contentEncryptionKey, $nonce));
        $tag = new AuthenticationTag($cipher->getTag());

        return new Cipher($cipherText, $tag, $salt, $senderPublicKey);
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
    private function addPadding($notification)
    {
        $length = $this->length;

        return pack('n*', $length).str_pad($notification, $length + 2, chr(0), STR_PAD_LEFT);
    }

    private static function hkdf($salt, $ikm, $info, $length)
    {
        $prk = hash_hmac('sha256', $ikm, $salt, true);

        return substr(hash_hmac('sha256', $info.chr(1), $prk, true), 0, $length);
    }
}
