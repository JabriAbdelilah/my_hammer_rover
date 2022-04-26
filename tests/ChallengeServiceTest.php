<?php

namespace App\Tests;

use App\Exception\BoundariesException;
use App\Service\ChallengeService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Exception\InvalidArgumentException;

class ChallengeServiceTest extends KernelTestCase
{
    //This test check the two examples given in the challenge
    /**
     * @dataProvider dataCasesOk
     *
     * @param string $plateauCoordinates
     * @param string $roverInitialPositions
     * @param string $instructions
     * @param string $roverExpectedFinalPositions
     */
    public function testRoverNavigateOk(
        string $plateauCoordinates,
        string $roverInitialPositions,
        string $instructions,
        string $roverExpectedFinalPositions
    ): void {
        self::bootKernel();
        $challengeService = static::getContainer()->get(ChallengeService::class);

        $plateauCoordinates = explode(' ', $plateauCoordinates);
        $result = $challengeService->navigate(
            $roverInitialPositions,
            $instructions,
            $plateauCoordinates[0],
            $plateauCoordinates[1],
            );

        $this->assertEquals($roverExpectedFinalPositions, $result);
    }

    //This test check if the user types an incorrect orientation
    public function testInvalidOrientation(): void
    {
        self::bootKernel();
        $challengeService = static::getContainer()->get(ChallengeService::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Orientation T is incorrect, please choose between N, S, E, W');

        $challengeService->navigate(
            '1 2 T',
            'LMLMLMLMM',
            5,
            5,
            );
    }

    //This test check if the user types an incorrect instruction
    public function testInvalidInstruction(): void
    {
        self::bootKernel();
        $challengeService = static::getContainer()->get(ChallengeService::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Instruction A is incorrect, please choose between L, R, M');

        $challengeService->navigate(
            '1 2 N',
            'LMAMLMLMM',
            5,
            5,
            );
    }

    //This test check when the rover reach the plateau limits
    public function testOutOfBoundaries(): void
    {
        self::bootKernel();
        $challengeService = static::getContainer()->get(ChallengeService::class);

        $this->expectException(BoundariesException::class);
        $this->expectExceptionMessage('You can not move the rover beyond the plateau boundaries');

        $challengeService->navigate(
            '1 2 N',
            'LMLMLMLMMMMMMMM',
            5,
            5,
            );
    }

    public function dataCasesOk()
    {
        return [
            ['5 5', '1 2 N', 'LMLMLMLMM', '1 3 N'],
            ['5 5', '3 3 E', 'MMRMMRMRRM', '5 1 E'],
        ];
    }
}
