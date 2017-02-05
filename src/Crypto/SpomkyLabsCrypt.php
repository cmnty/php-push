<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use AESGCM\AESGCM;
use Cmnty\Push\Crypto\Exception\UnsupportedEncryptionMethod;

class SpomkyLabsCrypt implements Crypt
{
    /**
     * Constructor.
     *
     * @throws UnsupportedEncryptionMethod When spomky-labs/php-aes-gcm is not installed.
     */
    public function __construct()
    {
        if (!class_exists(AESGCM::class)) {
            throw new UnsupportedEncryptionMethod('SpomkyLabsCrypt cannot be used without installing spomky-labs/php-aes-gcm.');
        }
    }

    /**
     * Encrypt the plain text sting.
     *
     * @param string $plainText
     * @param ContentEncryptionKey $contentEncryptionKey
     * @param Nonce $nonce
     * @param Salt $salt
     * @param PublicKey $senderPublicKey
     *
     * @return Cipher
     */
    public function encrypt(string $plainText, ContentEncryptionKey $contentEncryptionKey, Nonce $nonce, Salt $salt, PublicKey $senderPublicKey): Cipher
    {
        list($encryptedText, $tag) = AESGCM::encrypt($contentEncryptionKey->getRawKeyMaterial(), $nonce->getRawBytes(), $plainText, '');

        $cipherText = new CipherText(new BinaryString($encryptedText));
        $tag = new AuthenticationTag(new BinaryString($tag));

        return new Cipher($cipherText, $tag, $salt, $senderPublicKey);
    }
}
