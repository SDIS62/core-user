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
        $mock = Mockery::mock('SDIS62\Core\User\Entity\Profile\SdisProfile', array(
            new Core\Entity\User('male', 'kevin', 'dubuc', 'kdubuc@sdis62.fr'),
            'Lieutenant',
            'Poste',
        ))->makePartial();

        self::$object = $mock;
    }

    public function test_if_it_have_good_implementation()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile', self::$object);
    }

    public function test_if_it_have_a_user()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\User', self::$object->getUser());
    }

    public function test_if_it_have_a_grade()
    {
        $this->assertEquals('Lieutenant', self::$object->getGrade());
        $this->assertInternalType('string', self::$object->getGrade());
    }

    public function test_if_it_can_be_promoted()
    {
        self::$object->promote('General');
        $this->assertEquals('General', self::$object->getGrade());
    }

    public function test_if_it_have_a_poste()
    {
        $this->assertEquals('Poste', self::$object->getPoste());
        $this->assertInternalType('string', self::$object->getPoste());
    }
}
