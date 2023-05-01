<?php

namespace ElePHPant\Cookie\Cookie;


use ElePHPant\Cookie\Storage\{CookieStorage, CookieStorageInterface};
use ElePHPant\Cookie\Strategies\Encryption\EncryptionStrategyInterface;
use ElePHPant\Cookie\ValueObjects\{Config, Expiration};

/**
 * Class CookieTrait
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
trait CookieTrait
{
    /** @var array Stores the configuration array. */
    protected static array $configs = [];

    /** @var bool Indicates if encryption is enabled */
    protected static bool $isEncrypted = false;

    /** @var CookieStorageInterface Storage object for managing cookies. */
    protected static CookieStorageInterface $storage;

    /** @var EncryptionStrategyInterface|null Encryption strategy object. */
    protected static ?EncryptionStrategyInterface $encryptionStrategy;

    /**
     * Process the configuration array.
     *
     * @param array $configs The configuration array.
     */
    protected static function processConfig(array $configs): void
    {
        self::boot($configs);
    }

    /**
     * Initialize the trait by bootstrapping the necessary components.
     *
     * @param array $configs The configuration array.
     */
    private static function boot(array $configs): void
    {
        self::$storage = new CookieStorage();

        self::$configs = (new Config($configs))->toArray();
        self::$configs['expiration'] = new Expiration(self::$configs['expiration'] ?? 'minutes');

        if (!empty(self::$configs['encryption'])) {
            self::$isEncrypted = true;
            self::$encryptionStrategy = new self::$configs['encryption'](self::$configs);
        }
    }
}