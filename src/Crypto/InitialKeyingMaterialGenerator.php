<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Mdanter\Ecc\EccFactory;

class InitialKeyingMaterialGenerator
{
    /**
     * Generate the initial keying material from a PublicKey
     *
     * @param PublicKey $recipientPublicKey
     *
     * @return InitialKeyingMaterial
     */
    public function generateInitialKeyingMaterial(PublicKey $recipientPublicKey)
    {
        $math = EccFactory::getAdapter();
        $generator = EccFactory::getNistCurves()->generator256();

        $serverEccPrivateKey = $generator->createPrivateKey();
        $senderEccPublicKey = $serverEccPrivateKey->getPublicKey();

        $keyGenerator = new KeyGenerator($math, $generator);
        $recipientEccPublicKey = $keyGenerator->generatePublicKey($recipientPublicKey);
        $senderPublicKey = $keyGenerator->convertPublicKey($senderEccPublicKey);

        $ecDH = new EcDH($math);

        $ikm = new InitialKeyingMaterial(
            $ecDH->calculateSharedSecret($serverEccPrivateKey, $recipientEccPublicKey),
            $recipientPublicKey,
            $senderPublicKey
        );

        return $ikm;
    }
}
