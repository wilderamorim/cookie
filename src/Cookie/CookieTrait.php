<?php

namespace ElePHPant\Cookie\Cookie;


use ElePHPant\Cookie\Storage\{CookieStorage, CookieStorageInterface};
use ElePHPant\Cookie\Strategies\Encryption\EncryptionStrategyInterface;
use ElePHPant\Cookie\ValueObjects\{Option, Expiration};

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
    /** @var array Stores the option array. */
    protected static array $options = [];

    /** @var bool Indicates if encryption is enabled */
    protected static bool $isEncrypted = false;

    /** @var CookieStorageInterface Storage object for managing cookies. */
    protected static CookieStorageInterface $storage;

    /** @var EncryptionStrategyInterface|null Encryption strategy object. */
    protected static ?EncryptionStrategyInterface $encryptionStrategy;

    /** @var array|string[] Stores the default values for option array. */
    private static array $defaultValues = ['expiration' => 'minutes'];

    /**
     * Process the option array.
     *
     * @param array $options The option array.
     */
    public function __construct(array $options)
    {
        self::boot($options);
    }

    /**
     * Initialize the trait by bootstrapping the necessary components.
     *
     * @param array $options The option array.
     */
    private static function boot(array $options): void
    {
        $options = array_replace(self::$defaultValues, $options);

        self::$options = (new Option($options))->toArray();
        self::$storage = new CookieStorage(self::$options);

        if (!empty(self::$options['encryption'])) {
            self::$isEncrypted = true;
            self::$encryptionStrategy = new self::$options['encryption'](self::$options);
        }
    }
}