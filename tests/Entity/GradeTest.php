<?php

namespace SDIS62\Core\User\Entity;

use Mockery;
use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class GradeTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $mock = Mockery::mock('SDIS62\Core\User\Entity\Grade', array('Lieutenant', 10))->makePartial();

        self::$object = $mock;
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_have_a_label()
    {
        $this->assertEquals('Lieutenant', self::$object->getLabel());
        $this->assertInternalType('string', self::$object->getLabel());
    }

    public function test_if_it_have_a_value()
    {
        $this->assertEquals(10, self::$object->getValue());
        $this->assertInternalType('int', self::$object->getValue());
    }

    public function test_if_it_can_be_compared()
    {
        $grade = Mockery::mock('SDIS62\Core\User\Entity\Grade', array('Lieutenant', 10))->makePartial();

        $this->assertEquals(0, self::$object->compare($grade));
        $this->assertInternalType('int', self::$object->getValue());

        $grade = Mockery::mock('SDIS62\Core\User\Entity\Grade', array('Lieutenant', 12))->makePartial();

        $this->assertEquals(1, self::$object->compare($grade));
        $this->assertInternalType('int', self::$object->getValue());

        $grade = Mockery::mock('SDIS62\Core\User\Entity\Grade', array('Lieutenant', 5))->makePartial();

        $this->assertEquals(-1, self::$object->compare($grade));
        $this->assertInternalType('int', self::$object->getValue());
    }

    public function test_if_it_throw_an_exception_if_grade_is_not_valid()
    {
        try {
            self::$object->getType();
        } catch (Core\Exception\InvalidGradeException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }
}
