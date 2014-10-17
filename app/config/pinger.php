<?php

return [
    /**
     * Hosts to ping
     */
    'hosts' => [],

    /**
     * Notification system
     */
    'notifications' => [
        /**
         * Mailgun for email notification
         */
        'mailgun' => [
            'domain' => 'YOUR-MAILGUN-DOMAIN',
            'api_key' => 'YOUR-MAILGUN-API-KEY',
            'recipients' => []
        ]
    ]
];