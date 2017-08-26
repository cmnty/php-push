# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
## Added
- Support for VAPID.
- Support for openssl.

## Changed
- `PublicKeys` constructed from base64url encoded strings must now use `createFromBase64UrlEncodedString`.
- `AuthenticationTag` used by the `PushSubscription` is now called `AuthenticationSecret`.
- `AuthenticationSecret` constructed from base64url encoded strings must now use `createFromBase64UrlEncodedString`.
- `PushService` now throws `UnsupportedPushService` instead of `UnsupportedPushMessageSubscription`.
- Internals for the cryptography part are rewritten.

## Removed
- Dropped php 5.6 support

## [0.0.1] - 2016-09-07
## Added
- Initial release.

[Unreleased]: https://github.com/cmnty/php-push/compare/0.0.1...master
[0.0.1]: https://github.com/cmnty/php-push/releases/tag/0.0.1
