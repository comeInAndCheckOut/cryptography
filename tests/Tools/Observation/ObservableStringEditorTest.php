<?php declare(strict_types = 1);

namespace Tools\Observation;

use PHPUnit\Framework\TestCase;
use Observation\TestObserverSpy;
use Tools\Exceptions\EmptyStringParameterException;
use Tools\Exceptions\StringCharacterIndexOutOfBoundsException;
use Tools\Exceptions\OperationOnEmptyStringException;

class ObservableStringEditorTest extends TestCase
{
    /** @var ObservableStringEditor $observableStringEditor */
    private $observableStringEditor;

    /** @var TestObserverSpy $testObserverSpy */
    private $testObserverSpy;

    public function setUp()
    {
        $this->observableStringEditor = new ObservableStringEditor();

        $this->testObserverSpy = new TestObserverSpy();
        $this->observableStringEditor->addObserver($this->testObserverSpy);
    }

    /**
     * @throws EmptyStringParameterException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testObserversAreNotifiedWhenTheStringPropertyChanges()
    {
        $this->observableStringEditor->setString('ABC');

        $this->assertTrue(
            $this->testObserverSpy->hasMethodBeenCalledWith(
                'handleAction',
                [new StringChangedAction(['string' => 'ABC'])],
                false
            )
        );
    }

    /**
     * @throws EmptyStringParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testObserversAreNotifiedWhenThePointedCharacterIndexPropertyChanges()
    {
        $this->observableStringEditor->setString('ABC');
        $this->observableStringEditor->moveForwards();

        $this->assertTrue(
            $this->testObserverSpy->hasMethodBeenCalledWith(
                'handleAction',
                [
                    new PointerMovedAction([
                        'pointedCharacterIndex' => 1,
                        'pointedCharacter' => 'B'
                    ])
                ],
                false
            )
        );
    }

    /**
     * @throws EmptyStringParameterException
     * @throws OperationOnEmptyStringException
     * @throws StringCharacterIndexOutOfBoundsException
     */
    public function testObserversAreNotifiedWhenTheReadStringPropertyChanges()
    {
        $this->observableStringEditor->setString('ABC');
        $this->observableStringEditor->readPointedCharacter();

        $this->assertTrue(
            $this->testObserverSpy->hasMethodBeenCalledWith(
                'handleAction',
                [new ReadStringChangedAction(['readString' => 'A'])],
                false
            )
        );
    }
}
