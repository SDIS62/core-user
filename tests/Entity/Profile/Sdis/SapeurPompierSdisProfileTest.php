<?php

namespace SDIS62\Core\User\Test\Entity\Profile\Sdis;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class SapeurPompierSdisProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile(
            new Core\Entity\User('male', 'kevin', 'dubuc', 'kdubuc@sdis62.fr'),
            'Colonel',
            'Directeur',
            true
        );
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\Sdis\SapeurPompierSdisProfile', self::$object);
    }

    public function test_if_it_have_good_implementation()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile', self::$object);
    }

    public function test_if_it_have_a_user()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\User', self::$object->getUser());
    }

    public function test_if_it_have_a_type_sapeur_pompier()
    {
        $this->assertEquals('sapeur_pompier', self::$object->getType());
    }

    public function test_if_it_have_a_grade()
    {
        $this->assertEquals('Colonel', self::$object->getGrade());
    }

    public function test_if_it_have_a_poste()
    {
        $this->assertEquals('Directeur', self::$object->getPoste());
    }

    public function test_if_it_have_a_pro_flag()
    {
        $this->assertTrue(self::$object->isPro());

        self::$object->setPro(false);

        $this->assertFalse(self::$object->isPro());

        self::$object->setPro();

        $this->assertTrue(self::$object->isPro());
    }
}
