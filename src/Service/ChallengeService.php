<?php

namespace App\Service;

use App\Model\Orientation;
use App\Model\Position;
use Symfony\Component\Form\Exception\InvalidArgumentException;

class ChallengeService
{
    private const SPIN_LEFT = 'L';
    private const SPIN_RIGHT = 'R';
    private const MOVE  = 'M';

    private const INSTRUCTIONS = [
        self::SPIN_LEFT,
        self::SPIN_RIGHT,
        self::MOVE,
    ];

    public function navigate(
        string $roverInitialPosition,
        string $instructions,
        int $limitX,
        int $limitY
    ): string {
        $roverPositionArray = explode(' ', $roverInitialPosition);
        $position = new Position(
            new Orientation($roverPositionArray[2]),
            $roverPositionArray[0],
            $roverPositionArray[1]
        );

        $instructions = str_split(trim($instructions));
        foreach ($instructions as $instruction) {
            if (!in_array($instruction, self::INSTRUCTIONS)) {
                throw new InvalidArgumentException(
                    sprintf("Instruction %s is incorrect, please choose between %s",
                        $instruction,
                        implode(', ', self::INSTRUCTIONS)
                    )
                );
            }

            switch ($instruction) {
                case self::SPIN_LEFT:
                    $position->getOrientation()->spinToLeft();
                    break;
                case self::SPIN_RIGHT:
                    $position->getOrientation()->spinToRight();
                    break;
                case self::MOVE:
                    $position->move($limitX, $limitY);
                    break;
            }
        }

        return (string) $position;
    }
}
