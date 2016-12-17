<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\Exception\UnsupportedEncryptionMethod;
use Crypto\Cipher as ExtCryptoCipher;

class ExtCryptoCrypt implements Crypt
{
    /**
     * Constructor.
     *
     * @throws UnsupportedEncryptionMethod When ext-crypto is not installed of the version is incompatible with the version of php.
     */
    public function __construct()
    {
        if (!phpversion('crypto')) {
            throw new UnsupportedEncryptionMethod('ExtCryptoCrypt cannot be used without ext-crypto.');
        }

        if (PHP_VERSION_ID >= 70100 && version_compare(phpversion('crypto'), '0.3.0', '<')) {
            throw new UnsupportedEncryptionMethod('ext-crypto must be as least version 0.3.0 when using php 7.1 or higher.');
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
    public function encrypt(string $plainText, ContentEncryptionKey $contentEncryptionKey, Nonce $nonce, Salt $salt, PublicKey $senderPublicKey) : Cipher
    {
        $cipher = new ExtCryptoCipher('aes-128-gcm');
        $cipherText = new CipherText(new BinaryString($cipher->encrypt($plainText, $contentEncryptionKey->getRawKeyMaterial(), $nonce->getRawBytes())));
        $tag = new AuthenticationTag(new BinaryString($cipher->getTag()));

        return new Cipher($cipherText, $tag, $salt, $senderPublicKey);
    }
}
