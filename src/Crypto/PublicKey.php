<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class PublicKey extends KeyMaterial
{
    /**
     * Check whether or not the public key is valid.
     *
     * The key should be 65 characters long
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->getLength() === 65;
    }
}
