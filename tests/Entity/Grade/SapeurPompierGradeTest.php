<?php

namespace SDIS62\Core\User\Test\Entity\Grade;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class SapeurPompierGradeTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Grade\SapeurPompierGrade('Lieutenant', 10);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Grade\SapeurPompierGrade', self::$object);
    }

    public function test_if_it_have_a_type_sapeur_pompier()
    {
        $this->assertEquals('sapeur_pompier', self::$object->getType());
    }
}
