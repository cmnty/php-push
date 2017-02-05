<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class Info
{
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
     * @param PublicKey $recipientPublicKey
     * @param PublicKey $senderPublicKey
     */
    public function __construct(PublicKey $recipientPublicKey, PublicKey $senderPublicKey)
    {
        $this->recipientPublicKey = $recipientPublicKey;
        $this->senderPublicKey = $senderPublicKey;
    }

    public function getContentEncoding(string $type): string
    {
        if ($type === 'auth') {
            return
                'Content-Encoding: '
                .$type
                .chr(0)
            ;
        }

        return
            'Content-Encoding: '
            .$type
            .chr(0)
            .'P-256'
            .chr(0)
            .pack('n', $this->recipientPublicKey->getLength())
            .$this->recipientPublicKey->getRawKeyMaterial()
            .pack('n', $this->senderPublicKey->getLength())
            .$this->senderPublicKey->getRawKeyMaterial()
        ;
    }
}
