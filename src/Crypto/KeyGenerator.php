<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Mdanter\Ecc\EccFactory;

class KeyGenerator
{
    /**
     * Generate a KeyPair.
     *
     * @return KeyPair
     */
    public function generateKeyPair(): KeyPair
    {
        $generator = EccFactory::getNistCurves()->generator256();

        $eccPrivateKey = $generator->createPrivateKey();
        $privateKey = PrivateKey::createFromEccKey($eccPrivateKey);

        return new KeyPair($privateKey, $privateKey->getPublicKey());
    }
}
