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

## Usage

```php
use Cmnty\Push\AggregatePushService;
use Cmnty\Push\Client;
use Cmnty\Push\Crypto\AuthenticationTag;
use Cmnty\Push\Crypto\PublicKey;
use Cmnty\Push\EndPoint;
use Cmnty\Push\GooglePushService;
use Cmnty\Push\MozillaPushService;
use Cmnty\Push\Notification;
use Cmnty\Push\PushServiceRegistry;
use Cmnty\Push\Subscription;

$notification = new Notification('Hello', 'World!');
$subscription = new Subscription(new Endpoint('...'), new PublicKey('...'), new AuthenticationTag('...'));

$pushServiceRegistry = new PushServiceRegistry();
$pushServiceRegistry->addPushService(new GooglePushService('API Key'));
$pushServiceRegistry->addPushService(new MozillaPushService());
$pushService = new AggregatePushService($pushServiceRegistry);
$client = new Client($pushService);

$client->pushNotification($notification, $subscription);
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
