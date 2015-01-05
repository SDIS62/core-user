<?php

namespace SDIS62\Core\User\Test\Entity\Grade;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class AdministratifGradeTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Grade\AdministratifGrade('Redacteur', 10);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Grade\AdministratifGrade', self::$object);
    }

    public function test_if_it_have_a_type_administratif()
    {
        $this->assertEquals('administratif', self::$object->getType());
    }
}
