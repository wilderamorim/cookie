<?php

namespace ElePHPant\Cookie\ValueObjects;

use ElePHPant\Cookie\Strategies\Encryption\EncryptionStrategyInterface;
use ElePHPant\Cookie\Exceptions\{
    EmptyValuesException,
    InvalidOptionException,
    InvalidValueException,
    MissingDriversException
};

/**
 * Class Option
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
final class Option
{
    /** @var array */
    private array $options = [];

    /** @var array */
    private array $requiredDrivers = [];

    /**
     * @param array $options The options to be validated.
     * @throws MissingDriversException If any required driver is missing.
     * @throws EmptyValuesException If any required driver has an empty value.
     * @throws InvalidOptionException If there are invalid option keys.
     * @throws InvalidValueException If there are invalid option values.
     */
    public function __construct(array $options)
    {
        $this->validate($options);
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }

    /**
     * Validate the options by performing various validation checks.
     *
     * @param array $options The options to be validated.
     * @throws MissingDriversException If any required driver is missing.
     * @throws EmptyValuesException If any required driver has an empty value.
     * @throws InvalidOptionException If there are invalid option keys.
     * @throws InvalidValueException If there are invalid option values.
     * @return void
     */
    private function validate(array $options): void
    {
        $this->validateRequiredDrivers($options);
        $this->validateEmptyValues($options);
        $this->validateOptions($options);
        $this->validateValues($options);
    }

    /**
     * Validate the presence of required drivers in the options.
     *
     * @param array $options The options to be validated.
     * @throws MissingDriversException If any required driver is missing.
     * @return void
     */
    private function validateRequiredDrivers(array $options): void
    {
        $missingDrivers = array_diff($this->requiredDrivers, array_keys($options));
        if (!empty($missingDrivers)) {
            throw new MissingDriversException($missingDrivers);
        }
    }

    /**
     * Validate the absence of empty values for required drivers in the options.
     *
     * @param array $options The options to be validated.
     * @throws EmptyValuesException If any required driver has an empty value.
     * @return void
     */
    private function validateEmptyValues(array $options): void
    {
        $emptyValues = array_filter(
            $options, fn($value, $key) => empty($value) && in_array($key, $this->requiredDrivers), ARRAY_FILTER_USE_BOTH
        );
        if (!empty($emptyValues)) {
            throw new EmptyValuesException(array_keys($emptyValues));
        }
    }

    /**
     * Validate the options by checking if the keys are valid and expected.
     *
     * @param array $options The options to be validated.
     * @throws InvalidOptionException If there are invalid option keys.
     * @return void
     */
    private function validateOptions(array $options): void
    {
        $invalidOptions = array_diff_key($options, $this->getValidations($options));
        if (!empty($invalidOptions)) {
            throw new InvalidOptionException(array_keys($invalidOptions));
        }
    }

    /**
     * Validate the values of the options based on the defined validations.
     *
     * @param array $options The options to be validated.
     * @throws InvalidValueException If there are invalid option values.
     * @return void
     */
    private function validateValues(array $options): void
    {
        $validations = $this->getValidations($options);
        $invalidValues = array_filter($options, fn($value, $key) => !$validations[$key]($value), ARRAY_FILTER_USE_BOTH);
        if (!empty($invalidValues)) {
            throw new InvalidValueException(array_keys($invalidValues));
        }
    }

    /**
     * Get the array of validations for the options.
     *
     * @param array $options The options for which to retrieve validations.
     * @return \Closure[] An array of validations for the options.
     */
    private function getValidations(array $options): array
    {
        return [
            'expiration' => fn($value) => new Expiration($value),
            'encryption' => fn($value) => (new $value($options) instanceof EncryptionStrategyInterface),
            'encrypt_key' => fn($value) => is_string($value),
            'path' => fn($value) => is_string($value) && strpos($value, '/') === 0,
            'domain' => fn($value) => filter_var($value, FILTER_VALIDATE_DOMAIN),
            'secure' => fn($value) => is_bool($value),
            'httponly' => fn($value) => is_bool($value),
            'samesite' => fn($value) => (in_array($value, ['None', 'Lax', 'Strict']) && $value !== 'None') || (isset($options['secure']) && $value === 'None' && $options['secure'] === true),
        ];
    }
}
