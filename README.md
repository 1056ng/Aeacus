# Phalcon JWT Authentication Plugin

A simple plugin to authenticate JWT from Request in PHP with [firebase/php-jwt](https://github.com/firebase/php-jwt).


## Installation
Use composer to manage your dependencies and download:

```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/1056ng/Aeacus"
      }
    ],
    "require": {
      "1056ng/Aeacus": "~1.0"
    }
}
```

## Example
### setup
```php
$eventsManager = new \Phalcon\Events\Manager();
$eventsManager->attach('authorization', new \Aeacus\Middleware($di));
$app->setEventsManager($eventsManager);
```

### check
```php
function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Di\Injectable $injectable) {
  $publicKeys = [
    'kid1' => 'jwt.token.aaaa',
    'kid2' => 'jwt.token.bbbb'
  ];

  $di = $this->getDi();

  // check JWT from request
  $di->getEventsManager()->fire(\Aeacus\EventKeys::check, $injectable, $publicKeys);

  // get decoded jwt token
  $decodedToken = $di->get(\Aeacus\ServiceKeys::decodedToken);
}
```
