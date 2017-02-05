<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

interface Crypt
{
    /**
     * Encrypt the plain text sting.
     *
     * @param string $plainText
     * @param ContentEncryptionKey $contentEncryptionKey
     * @param Nonce $nonce
     * @param Salt $salt
     * @param PublicKey $privateKey
     *
     * @return Cipher
     */
    public function encrypt(string $plainText, ContentEncryptionKey $contentEncryptionKey, Nonce $nonce, Salt $salt, PublicKey $privateKey): Cipher;
}
