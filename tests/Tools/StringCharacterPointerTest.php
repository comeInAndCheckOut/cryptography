<?php
namespace Tools;

use PHPUnit\Framework\TestCase;

class StringCharacterPointerTest extends TestCase
{
    /** @var StringCharacterPointer $stringCharacterPointer */
    private $stringCharacterPointer;

    public function setUp()
    {
        $this->stringCharacterPointer = new StringCharacterPointer();
    }

    /**
     * @return array
     */
    public function initialPointedCharacterIndexOutOfBoundsDataProvider()
    {
        return [
            ['', 0],
            ['A', -1],
            ['A', 1]
        ];
    }

    /**
     * @expectedException \Tools\StringCharacterIndexOutOfBoundsException
     * @dataProvider initialPointedCharacterIndexOutOfBoundsDataProvider
     * @param string $string
     * @param int $initialPointedCharacterIndex
     */
    public function testSetStringThrowsIfInitialPointedCharacterIndexBoundsExceeded(
        $string,
        $initialPointedCharacterIndex
    ) {
        $upperBoundCharacterIndex = strlen($string) - 1;
        $this->expectExceptionMessage(
            'The given character index is outside the string bounds ' .
                "[0, $upperBoundCharacterIndex]: $initialPointedCharacterIndex."
        );

        $this->stringCharacterPointer->setString($string, $initialPointedCharacterIndex);
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsTheGivenString()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertEquals('ABC', $this->stringCharacterPointer->getString());
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsPointedCharacterIndexToZeroIfNoInitialIndexIsGiven()
    {
        $this->stringCharacterPointer->setString('ABC');

        $this->assertEquals(0, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testSetStringSetsTheGivenInitialPointedCharacterIndex()
    {
        $this->stringCharacterPointer->setString('ABC', 2);

        $this->assertEquals(2, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testMoveForwardsSetsThePointedCharacterIndexCorrectly()
    {
        $this->stringCharacterPointer->setString('ABC');
        $this->stringCharacterPointer->moveForwards();

        $this->assertEquals(1, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @return array
     */
    public function moveForwardsWithMultipleStepsDataProvider()
    {
        return [
            [0, 1, 1],
            [0, 2, 2],
            [0, 3, 0],
            [2, 1, 0],
            [2, 2, 1],
            [2, 3, 2],
            [2, 4, 0],
            [0, -1, 2],
            [0, -2, 1],
            [0, -3, 0],
            [0, -4, 2],
            [2, -1, 1],
            [2, -2, 0],
            [2, -3, 2]
        ];
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     * @dataProvider moveForwardsWithMultipleStepsDataProvider
     * @param int $initialPointedCharacterIndex
     * @param int $stepsCount
     * @param int $expectedPointedCharacterIndex
     */
    public function testMoveForwardsWithMultipleStepsSetsThePointedCharacterIndexCorrectly(
        $initialPointedCharacterIndex,
        $stepsCount,
        $expectedPointedCharacterIndex
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveForwards($stepsCount);

        $this->assertEquals($expectedPointedCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testMoveBackwardsSetsThePointedCharacterIndexCorrectly()
    {
        $this->stringCharacterPointer->setString('ABC');
        $this->stringCharacterPointer->moveBackwards();

        $this->assertEquals(2, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @return array
     */
    public function moveBackwardsWithMultipleStepsDataProvider()
    {
        return [
            [0, 1, 2],
            [0, 2, 1],
            [0, 3, 0],
            [0, 4, 2],
            [2, 1, 1],
            [2, 2, 0],
            [2, 3, 2],
            [0, -1, 1],
            [0, -2, 2],
            [0, -3, 0],
            [2, -1, 0],
            [2, -2, 1],
            [2, -3, 2],
            [2, -4, 0]
        ];
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     * @dataProvider moveBackwardsWithMultipleStepsDataProvider
     * @param int $initialPointedCharacterIndex
     * @param int $stepsCount
     * @param int $expectedPointerCharacterIndex
     */
    public function testMoveBackwardsWithMultipleStepsSetsThePointedCharacterIndexCorrectly(
        $initialPointedCharacterIndex,
        $stepsCount,
        $expectedPointerCharacterIndex
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);
        $this->stringCharacterPointer->moveBackwards($stepsCount);

        $this->assertEquals($expectedPointerCharacterIndex, $this->stringCharacterPointer->getPointedCharacterIndex());
    }

    /**
     * @return array
     */
    public function pointedCharacterDataProvider()
    {
        return [
            [0, 'A'],
            [1, 'B'],
            [2, 'C']
        ];
    }

    /**
     * @throws StringCharacterIndexOutOfBoundsException
     * @dataProvider pointedCharacterDataProvider
     * @param int $initialPointedCharacterIndex
     * @param string $expectedPointedCharacter
     */
    public function testGetPointedCharacterReturnsTheCorrectCharacter(
        $initialPointedCharacterIndex,
        $expectedPointedCharacter
    ) {
        $this->stringCharacterPointer->setString('ABC', $initialPointedCharacterIndex);

        $this->assertEquals($expectedPointedCharacter, $this->stringCharacterPointer->getPointedCharacter());
    }
}