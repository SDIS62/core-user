<?php

namespace SDIS62\Core\User\Test\Entity\Profile\Sdis;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class PersonnelTechniqueSdisProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $grade = new Core\Entity\Grade\TechniqueGrade('Ingenieur', 10);
        self::$object = new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile($grade, 'Chef de sercie paie');
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile', self::$object);
    }

    public function test_if_it_have_a_type_personnel_technique()
    {
        $this->assertEquals('personnel_technique', self::$object->getType());
    }

    public function test_if_it_have_a_technique_grade()
    {
        self::$object->setGrade(self::$object->getGrade());
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Grade\TechniqueGrade', self::$object->getGrade());
    }
}
