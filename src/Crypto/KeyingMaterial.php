<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

interface KeyingMaterial
{
    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawKeyMaterial() : string;
}
