<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class Info
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var PublicKey
     */
    private $recipientPublicKey;

    /**
     * @var PublicKey
     */
    private $senderPublicKey;

    /**
     * Constructor.
     *
     * @param string $type
     * @param PublicKey $recipientPublicKey
     * @param PublicKey $senderPublicKey
     */
    public function __construct($type, PublicKey $recipientPublicKey, PublicKey $senderPublicKey)
    {
        $this->type = $type;
        $this->recipientPublicKey = $recipientPublicKey;
        $this->senderPublicKey = $senderPublicKey;
    }

    public function getInfo()
    {
        return 'Content-Encoding: '
            .$this->type
            .chr(0)
            .'P-256'
            .chr(0)
            .pack('n', $this->recipientPublicKey->getLength())
            .$this->recipientPublicKey->getRawBytes()
            .pack('n', $this->senderPublicKey->getLength())
            .$this->senderPublicKey->getRawBytes()
        ;
    }
}
