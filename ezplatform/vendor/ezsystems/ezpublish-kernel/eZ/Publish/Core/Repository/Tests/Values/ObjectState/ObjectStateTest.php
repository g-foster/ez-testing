<?php

/**
 * This file is part of the eZ Publish Kernel package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\Core\Repository\Tests\Values\ObjectState;

use eZ\Publish\API\Repository\Tests\Values\ValueObjectTestTrait;
use eZ\Publish\Core\Repository\Values\ObjectState\ObjectState;
use PHPUnit_Framework_TestCase;

/**
 * Test internal integrity of @see \eZ\Publish\Core\Repository\Values\ObjectState\ObjectState ValueObject.
 */
class ObjectStateTest extends PHPUnit_Framework_TestCase
{
    use ValueObjectTestTrait;

    /**
     * Test a new class and default values on properties.
     *
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectState::__construct
     */
    public function testNewClass()
    {
        $objectState = new ObjectState();

        $this->assertPropertiesCorrect(
            [
                'id' => null,
                'identifier' => null,
                'priority' => null,
                'defaultLanguageCode' => null,
                'languageCodes' => null,
                'names' => [],
                'descriptions' => [],
            ],
            $objectState
        );
    }

    /**
     * Test retrieving missing property.
     *
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectState::__get
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectStateGroup::__get
     * @expectedException \eZ\Publish\API\Repository\Exceptions\PropertyNotFoundException
     */
    public function testMissingProperty()
    {
        $objectState = new ObjectState();
        $value = $objectState->notDefined;
        $this->fail('Succeeded getting non existing property');
    }

    /**
     * Test setting read only property.
     *
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectState::__set
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectStateGroup::__set
     * @expectedException \eZ\Publish\API\Repository\Exceptions\PropertyReadOnlyException
     */
    public function testReadOnlyProperty()
    {
        $objectState = new ObjectState();
        $objectState->id = 42;
        $this->fail('Succeeded setting read only property');
    }

    /**
     * Test if property exists.
     *
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectState::__isset
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectStateGroup::__isset
     */
    public function testIsPropertySet()
    {
        $objectState = new ObjectState();
        $value = isset($objectState->notDefined);
        $this->assertFalse($value);

        $value = isset($objectState->id);
        $this->assertTrue($value);
    }

    /**
     * Test unsetting a property.
     *
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectState::__unset
     * @covers \eZ\Publish\API\Repository\Values\ObjectState\ObjectStateGroup::__unset
     * @expectedException \eZ\Publish\API\Repository\Exceptions\PropertyReadOnlyException
     */
    public function testUnsetProperty()
    {
        $objectState = new ObjectState(array('id' => 2));
        unset($objectState->id);
        $this->fail('Unsetting read-only property succeeded');
    }
}
