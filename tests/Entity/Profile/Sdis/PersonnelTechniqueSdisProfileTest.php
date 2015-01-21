<?php

namespace SDIS62\Core\User\Test\Entity\Profile\Sdis;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class PersonnelTechniqueSdisProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile(
            new Core\Entity\User('male', 'kevin', 'dubuc', 'kdubuc@sdis62.fr'),
            'Ingenieur',
            'Developpeur'
        );
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile', self::$object);
    }

    public function test_if_it_have_good_implementation()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile', self::$object);
    }

    public function test_if_it_have_a_user()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\User', self::$object->getUser());
    }

    public function test_if_it_have_a_type_personnel_technique()
    {
        $this->assertEquals('personnel_technique', self::$object->getType());
    }

    public function test_if_it_have_a_grade()
    {
        $this->assertEquals('Ingenieur', self::$object->getGrade());
    }

    public function test_if_it_have_a_poste()
    {
        $this->assertEquals('Developpeur', self::$object->getPoste());
    }
}
