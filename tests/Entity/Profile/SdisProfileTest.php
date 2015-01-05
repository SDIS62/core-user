<?php

namespace SDIS62\Core\User\Test\Entity\Profile;

use Mockery;
use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class SdisProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $mock_grade = Mockery::mock('SDIS62\Core\User\Entity\Grade', array('Lieutenant', 10))->makePartial();
        $mock = Mockery::mock('SDIS62\Core\User\Entity\Profile\SdisProfile', array($mock_grade, 'Poste'))->makePartial();

        self::$object = $mock;
    }

    public function test_if_it_have_a_grade()
    {
        self::$object->setGrade(self::$object->getGrade());
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Grade', self::$object->getGrade());
    }

    public function test_if_it_have_a_poste()
    {
        $this->assertEquals('Poste', self::$object->getPoste());
        $this->assertInternalType('string', self::$object->getPoste());
    }
}
