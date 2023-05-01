<?php

namespace ElePHPant\Cookie\Cookie;


/**
 * Class Cookie
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
class Cookie
{
    use CookieTrait;

    /**
     * @param array $configs
     */
    public function __construct(array $configs = [])
    {
        $this->processConfig($configs);
    }

    /**
     * Set a cookie.
     *
     * @param string        $name       The name of the cookie.
     * @param mixed         $value      The value of the cookie.
     * @param int           $expiration The expiration time of the cookie in seconds.
     * @param string|null   $path       The path on the server in which the cookie will be available.
     * @return bool                     True if the cookie is set successfully, false otherwise.
     */
    public static function set(string $name, $value, int $expiration, ?string $path = null): bool
    {
        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        if (self::$isEncrypted) {
            $value = self::$encryptionStrategy->encrypt($value);
        }

        return self::$storage->set($name, $value, strtotime("+{$expiration} " . self::$configs['expiration']), $path);
    }

    /**
     * Get the value of a cookie.
     *
     * @param string|null $name The name of the cookie. If null, returns all cookies.
     * @return mixed            The value of the cookie, or an array of all cookies if $name is null.
     */
    public static function get(?string $name = null)
    {
        if (!$name) {
            return self::all();
        }

        $cookie = self::$storage->get($name);
        if ($cookie) {
            $cookie = self::$isEncrypted ? self::$encryptionStrategy->decrypt($cookie) : $cookie;
            return json_decode($cookie, true) ?? $cookie;
        }

        return null;
    }

    /**
     * Delete a cookie.
     *
     * @param string|null $name The name of the cookie. If null, deletes all cookies.
     * @param string|null $path The path on the server in which the cookie was available.
     * @return bool             True if the cookie is deleted successfully, false otherwise.
     */
    public static function destroy(?string $name = null, ?string $path = null): bool
    {
        return self::$storage->delete($name, $path);
    }

    /**
     * Check if a cookie exists and optionally check its value.
     *
     * @param string      $name  The name of the cookie.
     * @param string|null $value The expected value of the cookie. If null, only checks for existence.
     * @return bool              True if the cookie exists and its value matches the expected value (or only existence is checked), false otherwise.
     */
    public static function has(string $name, ?string $value = null): bool
    {
        $getCookie = self::$storage->get($name);

        if (!$value) {
            return $getCookie !== null;
        }

        $expectedValue = self::$isEncrypted ? self::$encryptionStrategy->encrypt($value) : $value;
        return $getCookie === $expectedValue;
    }

    /**
     * Set a cookie if it doesn't already exist, with an option to remove the existing cookie.
     *
     * @param string      $name         The name of the cookie.
     * @param mixed       $value        The value of the cookie.
     * @param int         $expiration   The expiration time of the cookie in seconds.
     * @param string|null $path         The path on the server in which the cookie will be available.
     * @param bool        $removeHas    Whether to remove the existing cookie if it exists.
     * @return bool|null                True if the cookie is set successfully, null if the cookie already exists and $removeHas is false.
     */
    public static function setDoesntHave(string $name, $value, int $expiration, ?string $path = null, bool $removeHas = false): ?bool
    {
        if (!self::has($name)) {
            return self::set($name, $value, $expiration, $path);
        }

        if ($removeHas) {
            return self::destroy($name);
        }

        return null;
    }

    /**
     * Get all cookies.
     *
     * @return array An associative array of all cookies, where the keys are the cookie names and the values are the cookie values.
     */
    private static function all(): array
    {
        $cookies = self::$storage->get() ?? [];
        $isBase64Encoded = fn(string $string): bool => $string === base64_encode(base64_decode($string));
        $isJson = fn(string $string): bool => json_decode($string) && json_last_error() === JSON_ERROR_NONE;

        return array_reduce(
            array_keys($cookies),
            fn($result, $key) => $result += [
                $key => self::$isEncrypted && $isBase64Encoded($cookies[$key])
                    ? (
                    $isJson(self::$encryptionStrategy->decrypt($cookies[$key]))
                        ? json_decode(self::$encryptionStrategy->decrypt($cookies[$key]), true)
                        : self::$encryptionStrategy->decrypt($cookies[$key])
                    )
                    : (
                    $isJson($cookies[$key])
                        ? json_decode($cookies[$key], true)
                        : $cookies[$key]
                    )
            ], []
        );
    }
}
