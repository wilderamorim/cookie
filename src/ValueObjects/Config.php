<?php

namespace ElePHPant\Cookie\ValueObjects;

use ElePHPant\Cookie\Strategies\Encryption\EncryptionStrategyInterface;
use ElePHPant\Cookie\Exceptions\{
    EmptyValuesException,
    InvalidConfigException,
    InvalidValueException,
    MissingDriversException
};

/**
 * Class Config
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
final class Config
{
    /** @var array */
    private array $configs = [];

    /** @var array */
    private array $requiredDrivers = [];

    /**
     * @param array $configs The configurations to be validated.
     * @throws MissingDriversException If any required driver is missing.
     * @throws EmptyValuesException If any required driver has an empty value.
     * @throws InvalidConfigException If there are invalid configuration keys.
     * @throws InvalidValueException If there are invalid configuration values.
     */
    public function __construct(array $configs)
    {
        $this->validate($configs);
        $this->configs = $configs;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->configs;
    }

    /**
     * Validate the configurations by performing various validation checks.
     *
     * @param array $configs The configurations to be validated.
     * @throws MissingDriversException If any required driver is missing.
     * @throws EmptyValuesException If any required driver has an empty value.
     * @throws InvalidConfigException If there are invalid configuration keys.
     * @throws InvalidValueException If there are invalid configuration values.
     * @return void
     */
    private function validate(array $configs): void
    {
        $this->validateRequiredDrivers($configs);
        $this->validateEmptyValues($configs);
        $this->validateConfigs($configs);
        $this->validateValues($configs);
    }

    /**
     * Validate the presence of required drivers in the configurations.
     *
     * @param array $configs The configurations to be validated.
     * @throws MissingDriversException If any required driver is missing.
     * @return void
     */
    private function validateRequiredDrivers(array $configs): void
    {
        $missingDrivers = array_diff($this->requiredDrivers, array_keys($configs));
        if (!empty($missingDrivers)) {
            throw new MissingDriversException($missingDrivers);
        }
    }

    /**
     * Validate the absence of empty values for required drivers in the configurations.
     *
     * @param array $configs The configurations to be validated.
     * @throws EmptyValuesException If any required driver has an empty value.
     * @return void
     */
    private function validateEmptyValues(array $configs): void
    {
        $emptyValues = array_filter(
            $configs, fn($value, $key) => empty($value) && in_array($key, $this->requiredDrivers), ARRAY_FILTER_USE_BOTH
        );
        if (!empty($emptyValues)) {
            throw new EmptyValuesException(array_keys($emptyValues));
        }
    }

    /**
     * Validate the configurations by checking if the keys are valid and expected.
     *
     * @param array $configs The configurations to be validated.
     * @throws InvalidConfigException If there are invalid configuration keys.
     * @return void
     */
    private function validateConfigs(array $configs): void
    {
        $invalidConfigs = array_diff_key($configs, $this->getValidations($configs));
        if (!empty($invalidConfigs)) {
            throw new InvalidConfigException(array_keys($invalidConfigs));
        }
    }

    /**
     * Validate the values of the configurations based on the defined validations.
     *
     * @param array $configs The configurations to be validated.
     * @throws InvalidValueException If there are invalid configuration values.
     * @return void
     */
    private function validateValues(array $configs): void
    {
        $validations = $this->getValidations($configs);
        $invalidValues = array_filter($configs, fn($value, $key) => !$validations[$key]($value), ARRAY_FILTER_USE_BOTH);
        if (!empty($invalidValues)) {
            throw new InvalidValueException(array_keys($invalidValues));
        }
    }

    /**
     * Get the array of validations for the configurations.
     *
     * @param array $configs The configurations for which to retrieve validations.
     * @return \Closure[] An array of validations for the configurations.
     */
    private function getValidations(array $configs): array
    {
        return [
            'expiration' => fn($value) => new Expiration($value),
            'encryption' => fn($value) => (new $value($configs) instanceof EncryptionStrategyInterface),
            'encrypt_key' => fn($value) => is_string($value),
        ];
    }
}
