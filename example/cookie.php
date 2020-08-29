<?php


require __DIR__ . '/assets/config.php';
require dirname(__DIR__, 1) . '/vendor/autoload.php';


use ElePHPant\Cookie\Cookie;


/**
 * show all
 */
var_dump($_COOKIE);

/**
 * create
 */
Cookie::set('food', 'egg', 20);

/**
 * get value
 */
echo Cookie::get('food');

echo '</br></br>';

/**
 * create value as array
 */
Cookie::set('user', [
    'name' => 'Wilder',
    'role' => 'Developer'
], 20);

/**
 * get value as array
 */
echo Cookie::get('user')['role'];

echo '</br></br>';

/**
 * remove
 */
//Cookie::destroy('food');
//Cookie::destroy('user');

/**
 * create if it doesn't exist
 */
Cookie::setDoesntHave('toggleSidebar', true, (43830 * 1));

/**
 * create if it doesn't exist AND DELETE IF IT EXISTS
 */
Cookie::setDoesntHave('toggleSidebar', true, (43830 * 1), '/', true);

/**
 * check if exists
 */
if (Cookie::has('food')) {
    echo 'exists';
} else {
    echo 'does not exist';
}

echo '</br></br>';

/**
 * check if exists by value
 */
if (Cookie::has('food', 'egg')) {
    echo 'the value is equal to egg';
} else {
    echo 'the value is different to egg';
}
