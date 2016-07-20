<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class Nonce extends BinaryString
{
    /**
     * Check whether or not the nonce is valid.
     *
     * The nonce should be 12 characters long
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->getLength() === 12;
    }
}
