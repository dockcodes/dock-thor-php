# DockTHOR PHP

Functions for the DockTHOR SDK that simplify the most common operations such as:

- capturing exceptions 
- capturing messages 
- sending events 
- working with breadcrumbs 
- managing scopes 
- starting transactions

Instead of interacting directly with SDK classes, this package exposes a set of global helper functions that internally use the currently active Thor SDK hub.

## Installation

Install via Composer:
```shell
composer require dockcodes/dock-thor
```

This package requires the main Thor SDK.

## Initialization

Before using any helper functions, initialize the SDK:
```php

use function Dock\Thor\init;

init([
    'dsn' => 'YOUR_DSN',
    'environment' => 'production',
]);
```

The init() function builds the client and binds it to the current SDK hub.

## Capturing Messages

Send a simple message event.
```php
use function Dock\Thor\captureMessage;

captureMessage('Something happened');
```
With severity level:
```php
captureMessage('Cache cleared', Severity::info());
```
## Capturing Exceptions

Capture and report exceptions.
```php

use function Dock\Thor\captureException;

try {
    riskyOperation();
} catch (\Throwable $e) {
    captureException($e);
}
```
## Capturing Custom Events

You can also send fully customized events.
```php
use function Dock\Thor\captureEvent;

$event = new Event();
$event->setMessage('Custom event');

captureEvent($event);
Capturing Last Error
```
## Capture the last PHP error.
```php
use function Dock\Thor\captureLastError;

captureLastError();
```
## Breadcrumbs

Breadcrumbs help track application activity before an error occurs.
```php
use function Dock\Thor\addBreadcrumb;

addBreadcrumb(new Breadcrumb(
Breadcrumb::LEVEL_INFO,
    'auth',
    'User logged in'
));
```
## Working with Scope

Modify the current scope.
```php
use function Dock\Thor\configureScope;

configureScope(function ($scope) {
    $scope->setTag('feature', 'payments');
});
```
## Create a temporary scope:
```php
use function Dock\Thor\withScope;

withScope(function ($scope) {
    $scope->setTag('operation', 'import');
});
```
## Transactions

Start a transaction for performance tracing.
```php
use function Dock\Thor\startTransaction;
use Dock\Thor\Tracing\TransactionContext;

$context = new TransactionContext();
$context->setName('order-processing');

$transaction = startTransaction($context);
```

# License

DockTHOR is open-source software licensed under the MIT license.

https://opensource.org/licenses/MIT