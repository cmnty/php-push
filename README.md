# cmnty/push

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Web Push library for PHP

## Instalation

Require the library with composer:
```bash
composer require cmnty/push
```

This library supports both `ext-crypto` and `lib-openssl` for it's encryption needs.
While a php fallback can be provided by `spomky-labs/php-aes-gcm` it is advised to use that only as a last resort.

## Usage

```php
<?php

use Cmnty\Push\AggregatePushService;
use Cmnty\Push\Client;
use Cmnty\Push\Crypto\AuthenticationSecret;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Endpoint;
use Cmnty\Push\GooglePushService;
use Cmnty\Push\MozillaPushService;
use Cmnty\Push\Notification;
use Cmnty\Push\PushServiceRegistry;
use Cmnty\Push\Subscription;

$notification = new Notification('Hello', 'World!');
$subscription = new Subscription(
    new Endpoint('...'),
    PublicKey::createFromBase64UrlEncodedString('...'),
    AuthenticationSecret::createFromBase64UrlEncodedString('...')
);

$pushServiceRegistry = new PushServiceRegistry();
$pushServiceRegistry->addPushService(new GooglePushService('API Key'));
$pushServiceRegistry->addPushService(new MozillaPushService());
$pushService = new AggregatePushService($pushServiceRegistry);
$client = new Client($pushService);

$client->pushNotification($notification, $subscription);
```

By default, the `Cmnty\Push\Crypto\AggregateCrypt` class is used to encrypt the notification.
This class tries to encrypt the notification using third party libraries or extensions in the following order:
* Encrypt using `ext-crypto` implemented by `Cmnty\Push\Crypto\ExtCryptoCrypt`
* Encrypt using `lib-openssl` implemented by `Cmnty\Push\Crypto\OpenSSLCrypt`
* Encrypt using native php implemented by `Cmnty\Push\Crypto\SpomkyLabsCrypt` using `spomky-labs/php-aes-gcm`

You can also force a certain library or extension to be used by passing it to the PushClient:
```php
<?php

use Cmnty\Push\Client;
use Cmnty\Push\Crypto\Cryptograph;
use Cmnty\Push\Crypto\ExtCryptoCrypt;

$pushService = ...;
$cryptograph = new Cryptograph(new ExtCryptoCrypt());
$client = new Client($pushService, null, $cryptograph);
```
If required, you can also provide your own implementation by implementing the `Cmnty\Push\Crypto\Crypt` interface.

## Vapid

In order to use the VAPID protocol, you will need to supply a `applicationServerKey` when subscribing to the push notifications in the browser. You can find an example on how to do so in this [push-notifications coldelab][link-push-notification-codelab] / [github][link-push-notification-codelab-github]

Once you have a 'VAPID enabled' subscription, sending the push notifications works the same as without VAPID using the `VapidPushService`. You can supply the keys (ECDSA using the P-256 Curve / ES256) as PEM encoded strings (recommended).

The subject claim passed to the token factory should include a contact URI for the application server as either a "mailto:" (email) or an "https:" URI.

For more information about VAPID, please check out the [Internet-Draft][link-vapid-draft].

**Note:** The push subscription is linked with the key it was made with. When you need to change your keys, the subscriptions made with the old ones will no longer work.

```php
<?php

use Cmnty\Push\Client;
use Cmnty\Push\Crypto\KeyPair;
use Cmnty\Push\Crypto\PrivateKey;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\Vapid\LcobucciJWTTokenFactory;
use Cmnty\Push\VapidPushService;

$privateKey = PrivateKey::createFromPem(file_get_contents('/path/to/private/key.pem'));
$publicKey = PublicKey::createFromPem(file_get_contents('/path/to/public/key.pem'));

$keyPair = new KeyPair($privateKey, $publicKey);

$tokenFactory = new LcobucciJWTTokenFactory($keyPair, 'mailto:johan@cmnty.com');
$pushService = new VapidPushService($tokenFactory);
$client = new Client($pushService);
```

## Framework Integration

* Symfony: [cmnty/push-bundle][link-symfony-bundle]

## Credits

- [Johan de Ruijter][link-jdr]
- [CMNTY Corporation][link-cmnty]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.


[ico-version]: https://img.shields.io/packagist/v/cmnty/push.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cmnty/push.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cmnty/push
[link-downloads]: https://packagist.org/packages/cmnty/push
[link-symfony-bundle]: https://github.com/cmnty/php-push-bundle
[link-jdr]: https://github.com/johanderuijter
[link-cmnty]: https://github.com/cmnty
[link-contributors]: ../../contributors

[link-push-notification-codelab]: https://developers.google.com/web/fundamentals/getting-started/codelabs/push-notifications/
[link-push-notification-codelab-github]: https://github.com/GoogleChrome/push-notifications/
[link-vapid-draft]: https://tools.ietf.org/html/draft-ietf-webpush-vapid
