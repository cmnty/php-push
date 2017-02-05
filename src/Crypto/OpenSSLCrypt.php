<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\Exception\UnsupportedEncryptionMethod;

class OpenSSLCrypt implements Crypt
{
    /**
     * Constructor.
     *
     * @throws UnsupportedEncryptionMethod When the version of php is insufficient.
     */
    public function __construct()
    {
        if (PHP_VERSION_ID < 70100) {
            throw new UnsupportedEncryptionMethod('OpenSSLCrypt can only be used on php 7.1 or higher. Current version is ' . PHP_VERSION);
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
        $encryptedText = openssl_encrypt($plainText, 'aes-128-gcm', $contentEncryptionKey->getRawKeyMaterial(), OPENSSL_RAW_DATA, $nonce->getRawBytes(), $tag);

        $cipherText = new CipherText(new BinaryString($encryptedText));
        $tag = new AuthenticationTag(new BinaryString($tag));

        return new Cipher($cipherText, $tag, $salt, $senderPublicKey);
    }
}
