<?php

namespace ElePHPant\Cookie\ValueObjects;

use ElePHPant\Cookie\Exceptions\InvalidParamException;

/**
 * Class Expiration
 *
 * Please report bugs on https://github.com/wilderamorim/cookie/issues
 *
 * @author Wilder Amorim <https://github.com/wilderamorim>
 * @link https://www.linkedin.com/in/wilderamorim/
 */
final class Expiration
{
    /** @var string The expiration unit. */
    private string $expiration;

    /** The valid expiration units. */
    private const VALID_UNITS = [
        'second', 'seconds',
        'minute', 'minutes',
        'hour', 'hours',
        'day', 'days',
        'week', 'weeks',
        'month', 'months',
        'year', 'years',
    ];

    /**
     * Create a new Expiration instance.
     *
     * @param string $expiration The expiration unit.
     * @throws InvalidParamException If the provided expiration unit is invalid.
     */
    public function __construct(string $expiration)
    {
        if (!in_array($expiration, self::VALID_UNITS)) {
            throw new InvalidParamException("Invalid expiration unit: '$expiration'.");
        }

        $this->expiration = $expiration;
    }

    /**
     * Get the string representation of the expiration unit.
     *
     * @return string The expiration unit.
     */
    public function __toString(): string
    {
        return $this->expiration;
    }
}