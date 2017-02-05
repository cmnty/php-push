<?php

namespace spec\Cmnty\Push\Crypto;

use Cmnty\Push\Crypto\AuthenticationTag;
use Cmnty\Push\Crypto\Cipher;
use Cmnty\Push\Crypto\CipherText;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Crypto\Salt;
use PhpSpec\ObjectBehavior;

class CipherSpec extends ObjectBehavior
{
    function let(CipherText $cipherText, AuthenticationTag $authenticationTag, Salt $salt, PublicKey $publicKey)
    {
        $cipherText->getRawBytes()->willReturn('raw_bytes');
        $authenticationTag->getRawBytes()->willReturn('raw_bytes');
        $salt->getBase64UrlEncodedString()->willReturn('base64url');
        $publicKey->getBase64UrlEncodedString()->willReturn('base64url');

        $this->beConstructedWith($cipherText, $authenticationTag, $salt, $publicKey);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Cipher::class);
    }

    function it_should_contain_the_cipher_text()
    {
        $this->getCipherText()->shouldReturnAnInstanceOf(CipherText::class);
    }

    function it_should_contain_the_raw_cipher_text()
    {
        $this->getRawCipherText()->shouldBeString();
    }

    function it_should_contain_the_authentication_tag()
    {
        $this->getAuthenticationTag()->shouldReturnAnInstanceOf(AuthenticationTag::class);
    }

    function it_should_contain_the_raw_authentication_tag()
    {
        $this->getRawAuthenticationTag()->shouldBeString();
    }

    function it_should_contain_the_salt()
    {
        $this->getSalt()->shouldReturnAnInstanceOf(Salt::class);
    }

    function it_should_contain_the_base64url_encoded_salt()
    {
        $this->getBase64UrlEncodedSalt()->shouldBeString();
    }

    function it_should_contain_the_public_key()
    {
        $this->getPublicKey()->shouldReturnAnInstanceOf(PublicKey::class);
    }

    function it_should_contain_the_base64url_encoded_public_key()
    {
        $this->getBase64UrlEncodedPublicKey()->shouldBeString();
    }
}
