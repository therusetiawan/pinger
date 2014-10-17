Pinger
======

CLI command to ping some host and send notification if the host unreached


Configuration
-------------

Configurations can be found on configs/pinger.php

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

Call this from commandline to invoke ping

```sh
php pinger ping
```


License
-------

MIT
