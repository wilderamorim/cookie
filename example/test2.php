<?php


require dirname(__DIR__, 1) . '/vendor/autoload.php';


/**
 *
 */
$options = [
    'expiration' => 'days',
    'encryption' => \ElePHPant\Cookie\Strategies\Encryption\Base64EncryptionStrategy::class,
    'encrypt_key' => 'ElePHPant',
];
$cookie = new \ElePHPant\Cookie\Cookie\Cookie($options);
$cookie::set('username1', 'john_doe', 5);

/**
 *
 */
$options['httponly'] = true;
$cookie = new \ElePHPant\Cookie\Cookie\Cookie($options);
$cookie::set('username2', 'john_doe', 5);

/**
 *
 */
$options['path'] = '/cookie';
$options['secure'] = true;
$options['httponly'] = false;
$cookie = new \ElePHPant\Cookie\Cookie\Cookie($options);
$cookie::set('username3', 'john_doe', 5);
