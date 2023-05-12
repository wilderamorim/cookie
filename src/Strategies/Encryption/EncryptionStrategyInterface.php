<?php

namespace ElePHPant\Cookie\Strategies\Encryption;

interface EncryptionStrategyInterface
{
    /**
     * Encrypt a value.
     *
     * @param string $value The value to encrypt.
     * @return string       The encrypted value.
     */
    public function encrypt(string $value): string;

    /**
     * Decrypt an encrypted value.
     *
     * @param string $encryptedValue The encrypted value to decrypt.
     * @return string|null           The decrypted value, or null if decryption fails.
     */
    public function decrypt(string $encryptedValue): ?string;

    /**
     * Boot the encryption strategy.
     *
     * @param array $options The option array.
     */
    public function boot(array $options): void;
}
