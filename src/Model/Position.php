<?php

namespace App\Model;

use App\Exception\BoundariesException;

class Position
{
    private Orientation $orientation;

    private int $xCoOrdinate;

    private int $yCoOrdinate;

    /**
     * Position constructor.
     *
     * @param Orientation $orientation
     * @param int         $xCoOrdinate
     * @param int         $yCoOrdinate
     */
    public function __construct(Orientation $orientation, int $xCoOrdinate, int $yCoOrdinate)
    {
        $this->orientation = $orientation;
        $this->xCoOrdinate = $xCoOrdinate;
        $this->yCoOrdinate = $yCoOrdinate;
    }

    /**
     * @return Orientation
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    public function move($limitX, $limitY)
    {
        switch ($this->orientation->getCurrentOrientation()) {
            case Orientation::NORTH:
                if ($this->isAllowedToMove($this->yCoOrdinate + 1, $limitY)) {
                    $this->yCoOrdinate++;
                    break;
                }

                throw new BoundariesException();
            case Orientation::SOUTH:
                if ($this->isAllowedToMove($this->yCoOrdinate - 1, $limitY)) {
                    $this->yCoOrdinate--;
                    break;
                }

                throw new BoundariesException();
            case Orientation::EAST:
                if ($this->isAllowedToMove($this->xCoOrdinate + 1, $limitX)) {
                    $this->xCoOrdinate++;
                    break;
                }

                throw new BoundariesException();
            case Orientation::WEST:
                if ($this->isAllowedToMove($this->xCoOrdinate - 1, $limitX)) {
                    $this->xCoOrdinate--;
                    break;
                }

                throw new BoundariesException();
        }
    }

    /**
     * @param int $nextPosition
     * @param int $limit
     *
     * @return bool
     */
    private function isAllowedToMove(int $nextPosition, int $limit): bool
    {
        return $nextPosition >= 0 && $nextPosition <= $limit;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return strval($this->xCoOrdinate) . ' ' . strval($this->yCoOrdinate) . ' ' . $this->orientation->getCurrentOrientation();
    }
}
