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
            $queryString = http_build_query($value);
            $value = $encrypt ? self::encrypt($queryString) : $queryString;
        } else {
            $value = $encrypt ? self::encrypt($value) : $value;
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
        $getCookie = self::getCookie($name);
        if (!$value) {
            if ($getCookie) {
                return true;
            }
        } else {
            if ($getCookie == ($encrypt ? self::encrypt($value) : $value)) {
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
        $getCookie = self::getCookie($name);
        if ($getCookie) {
            $cookie = $decrypt ? self::decrypt($getCookie) : $getCookie;
            parse_str($cookie, $isArray);
            $explode = explode('=', $cookie);
            if (!$isArray[$explode[0]]) {
                return $cookie;
            } else {
                parse_str($cookie, $data);
                return $data;
            }
        }
        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param int $minutes
     * @param string|null $path
     * @param bool $destroy
     * @return bool|null
     */
    public static function setDoesntHave(string $name, $value, int $minutes, ?string $path = null, bool $destroy = true)
    {
        if (!self::has($name)) {
            return self::set($name, $value, $minutes, $path);
        }
        if ($destroy) {
            return self::destroy($name);
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
     * @param string $name
     * @return mixed
     */
    private static function getCookie(string $name)
    {
        return filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_STRIPPED);
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

    public static function all()
    {
        echo '<pre>';
        var_dump($_COOKIE);
    }
}