<?php


return [
    'expiration' => 'days',
    'encryption' => \ElePHPant\Cookie\Strategies\Encryption\Base64EncryptionStrategy::class,
    'encrypt_key' => 'ElePHPant',
];