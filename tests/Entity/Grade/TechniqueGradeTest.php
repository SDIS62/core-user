<?php

namespace SDIS62\Core\User\Test\Entity\Grade;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class TechniqueGradeTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Grade\TechniqueGrade('Ingenieur', 10);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Grade\TechniqueGrade', self::$object);
    }

    public function test_if_it_have_a_type_technique()
    {
        $this->assertEquals('technique', self::$object->getType());
    }
}
