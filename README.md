# cmnty/push
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

* Symfony: [cmnty/push-bundle](https://github.com/cmnty/php-push-bundle)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
