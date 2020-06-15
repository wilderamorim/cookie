<?php


namespace ElePHPant\Cookie;


/**
 * Class Cookie
 * @package ElePHPant\Cookie
 */
class Cookie
{
    /**
     * @param string $name
     * @param mixed $value
     * @param int $minutes
     * @param string|null $path
     * @param bool $encrypt
     * @return bool
     */
    public static function set(string $name, $value, int $minutes, ?string $path = null, bool $encrypt = true): bool
    {
        if (is_array($value)) {
            $value = self::encrypt(http_build_query($value));
        } else {
            $value = ($encrypt ? self::encrypt($value) : $value);
        }
        return self::setCookie($name, $value, self::expire($minutes), $path);
    }

    /**
     * @param string $name
     * @param string|null $path
     * @return bool
     */
    public static function destroy(string $name, ?string $path = null): bool
    {
        return self::setCookie($name, null, -1, $path);
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param bool $encrypt
     * @return bool
     */
    public static function has(string $name, ?string $value = null, bool $encrypt = true): bool
    {
        $cookie = self::name($name);
        if (!$value) {
            if ($cookie) {
                return true;
            }
        } else {
            if ($cookie == ($encrypt ? self::encrypt($value) : $value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $name
     * @param bool $decrypt
     * @return mixed|string|null
     */
    public static function get(string $name, bool $decrypt = true)
    {
        $cookie = self::name($name);
        if ($cookie) {
            $decryptedCookie = self::decrypt($cookie);
            parse_str($decryptedCookie, $isArray);
            $explode = explode('=', $decryptedCookie);
            if (!$isArray[$explode[0]]) {
                return $decrypt ? $decryptedCookie : $cookie;
            } else {
                parse_str($decryptedCookie, $data);
                return $data;
            }
        }
        return null;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @param int $expire
     * @param string|null $path
     * @return bool
     */
    private static function setCookie(string $name, ?string $value, int $expire, ?string $path = null): bool
    {
        return setcookie($name, $value, $expire, ($path ?? '/'));
    }

    /**
     * @param int $minutes
     * @return int
     */
    private static function expire(int $minutes): int
    {
        return time() + (60 * $minutes);
    }

    /**
     * @param string $value
     * @return string
     */
    private static function encrypt(string $value): string
    {
        return base64_encode($value);
    }

    /**
     * @param string $value
     * @return string
     */
    private static function decrypt(string $value): string
    {
        return base64_decode($value);
    }

    /**
     * @param string $name
     * @return mixed
     */
    private static function name(string $name)
    {
        return filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_STRIPPED);
    }

    public static function all()
    {
        echo '<pre>';
        var_dump($_COOKIE);
    }
}