<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\Exception\UnsupportedEncryptionMethod;

class AggregateCrypt implements Crypt
{
    /**
     * @var Crypt
     */
    private $crypt;

    /**
     * Constructor.
     *
     * @throws UnsupportedEncryptionMethod When no supported encryption library can be found.
     */
    public function __construct()
    {
        $options = [
            ExtCryptoCrypt::class,
            OpenSSLCrypt::class,
            SpomkyLabsCrypt::class,
        ];

        foreach ($options as $crypt) {
            try {
                $this->crypt = new $crypt();

                return;
            } catch (UnsupportedEncryptionMethod $e) {}
        }

        throw new UnsupportedEncryptionMethod('No supported encryption library found. Please install one of the following libraries or extensions: ext-crypto, lib-openssl, or spomky-labs/php-aes-gcm.');
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
        return $this->crypt->encrypt($plainText, $contentEncryptionKey, $nonce, $salt, $senderPublicKey);
    }
}
