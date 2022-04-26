<?php

namespace App\Model;

use Symfony\Component\Form\Exception\InvalidArgumentException;

class Orientation
{
    public const NORTH = 'N';
    public const SOUTH = 'S';
    public const EAST  = 'E';
    public const WEST  = 'W';

    public const ORIENTATIONS = [
        self::NORTH,
        self::SOUTH,
        self::EAST,
        self::WEST,
    ];

    private string $currentOrientation;

    /**
     * Orientation constructor.
     *
     * @param string $currentOrientation
     */
    public function __construct(string $currentOrientation)
    {
        if (in_array($currentOrientation, self::ORIENTATIONS)) {
            $this->currentOrientation = $currentOrientation;
        } else {
            throw new InvalidArgumentException(
                sprintf("Orientation %s is incorrect, please choose between %s",
                    $currentOrientation,
                    implode(', ', self::ORIENTATIONS)
                )
            );
        }
    }

    /**
     * @return string
     */
    public function getCurrentOrientation()
    {
        return $this->currentOrientation;
    }

    /**
     * @param string $currentOrientation
     */
    public function setCurrentOrientation(string $currentOrientation): void
    {
        $this->currentOrientation = $currentOrientation;
    }

    public function spinToLeft(): void
    {
        switch ($this->currentOrientation) {
            case self::NORTH:
                $this->currentOrientation = self::WEST;
                break;
            case self::SOUTH:
                $this->currentOrientation = self::EAST;
                break;
            case self::EAST:
                $this->currentOrientation = self::NORTH;
                break;
            case self::WEST:
                $this->currentOrientation = self::SOUTH;
                break;
        }
    }

    public function spinToRight(): void
    {
        switch ($this->currentOrientation) {
            case self::NORTH:
                $this->currentOrientation = self::EAST;
                break;
            case self::SOUTH:
                $this->currentOrientation = self::WEST;
                break;
            case self::EAST:
                $this->currentOrientation = self::SOUTH;
                break;
            case self::WEST:
                $this->currentOrientation = self::NORTH;
                break;
        }
    }
}
