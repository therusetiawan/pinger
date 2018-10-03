[![Build Status](https://travis-ci.org/herloct/pinger.svg?branch=develop)](https://travis-ci.org/herloct/pinger) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/herloct/pinger/badges/quality-score.png?b=feature%2Fuse_simpler_ping)](https://scrutinizer-ci.com/g/herloct/pinger/) [![Code Coverage](https://scrutinizer-ci.com/g/herloct/pinger/badges/coverage.png?b=feature%2Fuse_simpler_ping)](https://scrutinizer-ci.com/g/herloct/pinger/)

Pinger
======

CLI command using PHP to ping some host and send notification if the host unreached


Configuration
-------------

Configurations can be found on config/pinger.php

```php
<?php

return [
    /**
     * Hosts to ping
     */
    'hosts' => [
        '192.168.0.101',
        'www.google.com'
    ],
    
    /**
     * Notification system
     */
    'notifications' => [
        /**
         * Mailgun for email notification
         */
        'mailgun' => [
            'domain' => 'your-mailgun-domain',
            'api_key' => 'your-mailgun-api-key',
            'recipients' => [
                'someone@domain.com',
                'other@domain.com'
            ]
        ]
    ]
];
```


CLI Usage
---------

Call this from command line to invoke ping

```sh
php pinger ping
```

Call this commands to generate the documentation

```sh
vendor/bin/phpmd --reportfile build/phpmd.xml src/ xml cleancode,codesize,controversial,design,naming,unusedcode
```

```sh
vendor/bin/phpcs --report=xml --report-file=build/phpcs.xml --standard=vendor/m6web/symfony2-coding-standard/Symfony2 src/
```

```sh
vendor/bin/phploc --log-xml=build/phploc.xml src/
```

```sh
vendor/bin/phpdox
```


License
-------

MIT
