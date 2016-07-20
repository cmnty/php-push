<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class AuthenticationTag extends KeyMaterial
{
    /**
     * Check whether or not the authentication tag is valid.
     *
     * The tag should be 16 characters long
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->getLength() === 16;
    }
}
