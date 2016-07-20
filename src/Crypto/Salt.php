<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class Salt extends BinaryString
{
    /**
     * Named constructor.
     *
     * @param int $length
     *
     * @return Salt
     */
    public static function createWithLength($length)
    {
        return new Salt(random_bytes($length));
    }

    /**
     * Check whether or not salt is valid.
     *
     * The salt should be 16 characters long
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->getLength() === 16;
    }
}
