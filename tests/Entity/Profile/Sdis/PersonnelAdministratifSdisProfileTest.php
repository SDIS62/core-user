<?php

namespace SDIS62\Core\User\Test\Entity\Profile\Sdis;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class PersonnelAdministratifSdisProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile(
            new Core\Entity\User('male', 'kevin', 'dubuc', 'kdubuc@sdis62.fr'),
            'Redacteur',
            'Controlleur finance'
        );
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile', self::$object);
    }

    public function test_if_it_have_good_implementation()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile', self::$object);
    }

    public function test_if_it_have_a_user()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\User', self::$object->getUser());
    }

    public function test_if_it_have_a_type_personnel_administratif()
    {
        $this->assertEquals('personnel_administratif', self::$object->getType());
    }

    public function test_if_it_have_a_grade()
    {
        $this->assertEquals('Redacteur', self::$object->getGrade());
    }

    public function test_if_it_have_a_poste()
    {
        $this->assertEquals('Controlleur finance', self::$object->getPoste());
    }
}
