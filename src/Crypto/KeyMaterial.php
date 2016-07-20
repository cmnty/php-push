<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Base64Url\Base64Url;

abstract class KeyMaterial extends BinaryString
{
    /**
     * Check whether or not the key material is valid.
     *
     * @return boolean
     */
    abstract public function isValid();
}
