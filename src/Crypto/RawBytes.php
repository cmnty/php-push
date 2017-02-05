<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

interface RawBytes
{
    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawBytes(): string;
}
