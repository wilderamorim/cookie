<?php

namespace ElePHPant\Cookie\Strategies\Encryption;

use ElePHPant\Cookie\Exceptions\InvalidParamException;

/**
 * Class AES256EncryptionStrategy
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
class AES256EncryptionStrategy implements EncryptionStrategyInterface
{
    /** @var string The encryption key used for AES-256 encryption. */
    private string $encryptKey;

    /**
     * Create a new instance of AES256EncryptionStrategy.
     *
     * @param array $options The option array.
     */
    public function __construct(array $options)
    {
        $this->boot($options);
    }

    /**
     * Encrypt a value using AES-256 encryption.
     *
     * @param string $value The value to encrypt.
     * @return string       The encrypted value.
     */
    public function encrypt(string $value): string
    {
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($value, 'aes-256-cbc', $this->encryptKey, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypt an encrypted value using AES-256 encryption.
     *
     * @param string $encryptedValue The encrypted value to decrypt.
     * @return string|null           The decrypted value, or null if decryption fails.
     */
    public function decrypt(string $encryptedValue): ?string
    {
        $encryptedValue = base64_decode($encryptedValue, true);
        if ($encryptedValue === false) {
            return null;
        }

        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($encryptedValue, 0, $ivLength);
        $encrypted = substr($encryptedValue, $ivLength);

        $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $this->encryptKey, OPENSSL_RAW_DATA, $iv);
        if ($decrypted === false) {
            return null;
        }

        return $decrypted;
    }

    /**
     * Boot the encryption strategy by setting the encryption key.
     *
     * @param array $options The option array.
     * @throws InvalidParamException If the encryption key is missing in the option.
     */
    public function boot(array $options): void
    {
        if (!in_array('encrypt_key', array_keys($options))) {
            throw new InvalidParamException('Encryption key is missing in params.');
        }

        $this->encryptKey = $options['encrypt_key'];
    }
}
