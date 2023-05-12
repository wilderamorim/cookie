<?php

namespace ElePHPant\Cookie\Strategies\Encryption;

/**
 * Class Base64EncryptionStrategy
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
class Base64EncryptionStrategy implements EncryptionStrategyInterface
{
    /**
     * Encrypt a value using base64 encoding.
     *
     * @param string $value The value to encrypt.
     * @return string       The encrypted value.
     */
    public function encrypt(string $value): string
    {
        return base64_encode($value);
    }

    /**
     * Decrypt an encrypted value using base64 decoding.
     *
     * @param string $encryptedValue The encrypted value to decrypt.
     * @return string               The decrypted value.
     */
    public function decrypt(string $encryptedValue): string
    {
        return base64_decode($encryptedValue);
    }

    /**
     * Boot the encryption strategy.
     *
     * @param array $options The option array.
     */
    public function boot(array $options): void
    {
        // TODO: Implement any necessary initialization logic.
    }
}
