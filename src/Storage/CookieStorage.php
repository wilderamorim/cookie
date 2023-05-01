<?php

namespace ElePHPant\Cookie\Storage;


/**
 * Class CookieStorage
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
class CookieStorage implements CookieStorageInterface
{
    /**
     * Set a cookie.
     *
     * @param string      $name   The name of the cookie.
     * @param string|null $value  The value of the cookie.
     * @param int         $expire The expiration time of the cookie as a Unix timestamp.
     * @param string|null $path   The path on the server in which the cookie will be available.
     * @return bool               True if the cookie is set successfully, false otherwise.
     */
    public function set(string $name, ?string $value, int $expire, ?string $path = null): bool
    {
        return setcookie($name, $value, $expire, ($path ?? '/'));
    }

    /**
     * Get the value of a cookie or all cookies.
     *
     * @param string|null $name The name of the cookie. If null, returns an array of all cookies.
     * @return mixed            The value of the cookie or an array of all cookies.
     */
    public function get(?string $name = null)
    {
        if (!$name) {
            return filter_input_array(INPUT_COOKIE, FILTER_DEFAULT);
        }

        return filter_input(INPUT_COOKIE, $name, FILTER_DEFAULT);
    }

    /**
     * Delete a cookie or all cookies.
     *
     * @param string|null $name The name of the cookie. If null, deletes all cookies.
     * @param string|null $path The path on the server in which the cookie was available.
     * @return bool             True if the cookie(s) is deleted successfully, false otherwise.
     */
    public function delete(?string $name = null, ?string $path = null): bool
    {
        if (!$name) {
            array_map(fn($name) => $this->set($name, null, -1, $path), array_keys($_COOKIE));
            return true;
        }

        return $this->set($name, null, -1, $path);
    }
}
