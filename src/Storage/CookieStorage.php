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
    /** @var array  The cookie options array. */
    private array $cookieOptions;

    /** @var string The expiration time unit. */
    private string $expiration;

    /** Default options for the cookie. */
    private const DEFAULT_VALUES = [
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => false,
    ];

    /**
     * @param array $options The options array for the cookie storage.
     */
    public function __construct(array $options)
    {
        $this->expiration = $options['expiration'];
        $this->cookieOptions = array_intersect_key($options, array_flip(array_keys(self::DEFAULT_VALUES)));
        $this->cookieOptions = array_replace(self::DEFAULT_VALUES, $this->cookieOptions);
    }

    /**
     * Set a cookie.
     *
     * @param string      $name   The name of the cookie.
     * @param string|null $value  The value of the cookie.
     * @param int         $expire The expiration time of the cookie as a Unix timestamp.
     * @return bool               True if the cookie is set successfully, false otherwise.
     */
    public function set(string $name, ?string $value, int $expire): bool
    {
        $this->cookieOptions['expires'] = strtotime("+$expire $this->expiration");
        return setcookie($name, $value, $this->cookieOptions);
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
     * @return bool             True if the cookie(s) is deleted successfully, false otherwise.
     */
    public function delete(?string $name = null): bool
    {
        $options = array_merge($this->cookieOptions, ['expires' => -1]);
        if (!$name) {
            array_map(fn($name) => setcookie($name, null, $options), array_keys($_COOKIE));
            return true;
        }

        return setcookie($name, null, $options);
    }
}
