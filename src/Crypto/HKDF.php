<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class HKDF
{
    /**
     * HMAC-based Extract-and-Expand Key Derivation Function (HKDF)
     *
     * @see https://tools.ietf.org/html/rfc5869
     *
     * @param RawBytes $salt
     * @param KeyingMaterial $keyingMaterial
     * @param string $info
     * @param int $length
     *
     * @return BinaryString
     */
    public function __invoke(RawBytes $salt, KeyingMaterial $keyingMaterial, string $info, int $length): BinaryString
    {
        return $this->extractAndExpand($salt, $keyingMaterial, $info, $length);
    }

    /**
     * HMAC-based Extract-and-Expand Key Derivation Function (HKDF)
     *
     * @see https://tools.ietf.org/html/rfc5869
     *
     * @param RawBytes $salt
     * @param KeyingMaterial $keyingMaterial
     * @param string $info
     * @param int $length
     *
     * @return BinaryString
     */
    public function extractAndExpand(RawBytes $salt, KeyingMaterial $keyingMaterial, string $info, int $length): BinaryString
    {
        $pseudoRandomKey = $this->extract($salt, $keyingMaterial);
        $outputKeyingMaterial = $this->expand($pseudoRandomKey, $info, $length);

        return $outputKeyingMaterial;
    }

    /**
     * Extract
     *
     * @see https://tools.ietf.org/html/rfc5869#section-2.2
     *
     * @param RawBytes $salt
     * @param KeyingMaterial $keyingMaterial
     *
     * @return BinaryString
     */
    private function extract(RawBytes $salt, KeyingMaterial $keyingMaterial): BinaryString
    {
        return new BinaryString(hash_hmac('sha256', $keyingMaterial->getRawKeyMaterial(), $salt->getRawBytes(), true));
    }

    /**
     * Expand
     *
     * @see https://tools.ietf.org/html/rfc5869#section-2.3
     *
     * @param RawBytes $pseudoRandomKey
     * @param string $info
     * @param int $length
     *
     * @return BinaryString
     */
    private function expand(RawBytes $pseudoRandomKey, string $info, int $length): BinaryString
    {
        $T = new BinaryString('');
        $outputKeyingMaterial = new BinaryString('');

        for ($blockIndex = 1; $blockIndex <= (int) ceil($length / 32); $blockIndex++) {
            $T = new BinaryString(hash_hmac(
                'sha256',
                $T->getRawBytes() . $info . chr($blockIndex),
                $pseudoRandomKey->getRawBytes(),
                true
            ));
            $outputKeyingMaterial = $outputKeyingMaterial->concat($T);
        }

        return $outputKeyingMaterial->slice($length);
    }
}
