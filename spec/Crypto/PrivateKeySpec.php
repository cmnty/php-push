<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\KeyingMaterial;
use Cmnty\Push\Crypto\PrivateKey;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Crypto\SharedSecret;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\EccFactory;
use PhpSpec\ObjectBehavior;

class PrivateKeySpec extends ObjectBehavior
{
    function let()
    {
        $generator = EccFactory::getNistCurves()->generator256();
        $eccPrivateKey = $generator->createPrivateKey();

        $this->beConstructedThrough('createFromEccKey', [$eccPrivateKey]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PrivateKey::class);
    }

    function it_should_contain_an_ecc_private_key()
    {
        $this->getEccKey()->shouldReturnAnInstanceOf(PrivateKeyInterface::class);
    }

    function it_should_be_able_to_generate_a_public_key()
    {
        $this->getPublicKey()->shouldReturnAnInstanceOf(PublicKey::class);
    }

    function it_should_be_able_to_calculate_a_shared_secret(PublicKey $publicKey)
    {
        $generator = EccFactory::getNistCurves()->generator256();
        $eccPrivateKey = $generator->createPrivateKey();

        $publicKey->getEccKey()->willReturn($eccPrivateKey->getPublicKey());

        $this->calculateSharedSecret($publicKey)->shouldReturnAnInstanceOf(SharedSecret::class);
    }

    function it_should_have_a_non_public_constructor()
    {
        $this->beConstructedWith();
        $this->shouldThrow('Throwable')->duringInstantiation();
    }
}
