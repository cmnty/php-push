<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\BinaryString;
use Cmnty\Push\Crypto\KeyingMaterial;
use Cmnty\Push\Crypto\PublicKey;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\EccFactory;
use PhpSpec\ObjectBehavior;

class PublicKeySpec extends ObjectBehavior
{
    function let(BinaryString $binaryString)
    {
        $this->beConstructedWith($binaryString);

        $binaryString->getRawBytes()->willReturn('raw_bytes');
        $binaryString->getLength()->willReturn(65);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PublicKey::class);
    }

    function it_should_implement_keying_material()
    {
        $this->shouldImplement(KeyingMaterial::class);
    }

    function it_should_contain_the_raw_key_material()
    {
        $this->getRawKeyMaterial()->shouldBeString();
    }

    function it_can_calculate_its_own_length()
    {
        $this->getLength()->shouldBeInt();
    }

    function it_should_throw_an_exception_if_the_public_key_has_an_invalid_length(BinaryString $binaryString)
    {
        $binaryString->getLength()->willReturn(64);
        $this->shouldThrow('InvalidArgumentException')->duringInstantiation();
    }

    function it_can_be_created_from_a_base64url_encoded_string()
    {
        $this->beConstructedThrough('createFromBase64UrlEncodedString', [
            'BEVYVy0G5j5KhryGGTGZNJejRZJRRVa1BLsCFxZQVZBtLFEso1Tkug8Zji3zX7JPoyLzYn7RXMfj3hd6MwLTqsk',
        ]);

        $this->shouldHaveType(PublicKey::class);
    }

    function it_can_be_created_from_an_ecc_key()
    {
        $generator = EccFactory::getNistCurves()->generator256();
        $eccPrivateKey = $generator->createPrivateKey();

        $this->beConstructedThrough('createFromEccKey', [$eccPrivateKey->getPublicKey()]);

        $this->shouldHaveType(PublicKey::class);
    }

    function it_can_generate_an_ecc_key()
    {
        $this->beConstructedThrough('createFromBase64UrlEncodedString', [
            'BEVYVy0G5j5KhryGGTGZNJejRZJRRVa1BLsCFxZQVZBtLFEso1Tkug8Zji3zX7JPoyLzYn7RXMfj3hd6MwLTqsk',
        ]);

        $this->getEccKey()->shouldReturnAnInstanceOf(PublicKeyInterface::class);
    }
}
