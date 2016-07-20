<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class InitialKeyingMaterial extends KeyMaterial
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
     * @param string    $keyMaterial
     * @param PublicKey $recipientPublicKey
     * @param PublicKey $senderPublicKey
     */
    public function __construct($keyMaterial, PublicKey $recipientPublicKey, PublicKey $senderPublicKey)
    {
        $this->recipientPublicKey = $recipientPublicKey;
        $this->senderPublicKey = $senderPublicKey;

        parent::__construct($keyMaterial);
    }

    /**
     * Check whether or not the shared secret is valid.
     *
     * The secret should be 32 characters long
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->getLength() === 32;
    }

    /**
     * Get the public key of the recipient of the message.
     *
     * @return PublicKey
     */
    public function getRecipientPublicKey()
    {
        return $this->recipientPublicKey;
    }

    /**
     * Get the public key created by the server.
     *
     * @return PublicKey
     */
    public function getServerPublicKey()
    {
        return $this->senderPublicKey;
    }
}
