<?php

namespace SDIS62\Core\User\Test\Entity\Profile\Sdis;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class SapeurPompierSdisProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $grade = new Core\Entity\Grade\SapeurPompierGrade('Colonel', 10);
        self::$object = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($grade, 'Directeur', true);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\Sdis\SapeurPompierSdisProfile', self::$object);
    }

    public function test_if_it_have_a_type_sapeur_pompier()
    {
        $this->assertEquals('sapeur_pompier', self::$object->getType());
    }

    public function test_if_it_have_a_sapeur_pompier_grade()
    {
        self::$object->setGrade(self::$object->getGrade());
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Grade\SapeurPompierGrade', self::$object->getGrade());
    }

    public function test_if_it_throw_an_exception_if_grade_is_not_correspond_with_profile()
    {
        try {
            self::$object->setGrade(new Core\Entity\Grade\AdministratifGrade('Redacteur', 10));
        } catch (Core\Exception\InvalidGradeException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }
}
