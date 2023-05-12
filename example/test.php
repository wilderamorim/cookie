<?php

error_reporting(E_ALL);
ini_set('display_errors', '0');
//set_exception_handler(fn($exception) => print($exception->getMessage()));


require dirname(__DIR__, 1) . '/vendor/autoload.php';


$options = include __DIR__ . '/config/cookie.php';
$cookie = new \ElePHPant\Cookie\Cookie\Cookie($options);


/**
 * show all
 */
echo '<pre>';
print_r([
    $_COOKIE,
    $cookie::get(),
]);
echo '</pre>';


/**
 * create
 */
$cookie::set('username', 'john_doe', 5);


/**
 * get value
 */
echo $cookie::get('username');


/**
 * create value as array
 */
$arrayValue = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 30,
];
$cookie::set('user', $arrayValue, 5);


/**
 * get value as array
 */
$user = $cookie::get('user');
echo $user['email'];


/**
 * remove
 */
$cookie::destroy('username');
$cookie::destroy();


/**
 * create if it doesn't exist
 */
$cookie::setDoesntHave('cookie_consent', true, 5);


/**
 * create if it doesn't exist AND DELETE IF IT EXISTS
 */
$cookie::setDoesntHave('toggle_sidebar', true, 5, true);


/**
 * check if exists
 */
if ($cookie::has('food')) {
    echo 'The cookie exists.';
} else {
    echo 'The cookie does not exist.';
}


/**
 * check if exists by value
 */
if ($cookie::has('username', 'john_doe')) {
    echo 'The cookie exists with the correct value.';
} else {
    echo 'The cookie does not exist or has a different value.';
}


/**
 * check if exists by array value
 */
if ($cookie::has('user', $arrayValue)) {
    echo 'The cookie exists with the correct value.';
} else {
    echo 'The cookie does not exist or has a different value.';
}
