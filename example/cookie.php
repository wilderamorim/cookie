<?php


require __DIR__ . '/assets/config.php';
require dirname(__DIR__, 1) . '/vendor/autoload.php';


use ElePHPant\Cookie\Cookie;


/**
 * show all
 */
Cookie::all();

/**
 * create
 */
Cookie::set('food', 'egg', 2);

/**
 * create value as array
 */
Cookie::set('users', [
    'name' => 'Wilder',
    'role' => 'Developer'
], 2);

/**
 * get from array value
 */
echo Cookie::get('users')['role'];

echo '</br></br>';

/**
 * remove
 */
//Cookie::destroy('food');
//Cookie::destroy('users');

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
