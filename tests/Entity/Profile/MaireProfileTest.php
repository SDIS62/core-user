<?php

namespace SDIS62\Core\User\Test\Entity\Profile;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class MaireProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Profile\MaireProfile(62000);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\MaireProfile', self::$object);
    }

    public function test_if_it_have_a_type_maire()
    {
        $this->assertEquals('maire', self::$object->getType());
    }

    public function test_if_it_have_a_code_insee()
    {
        $this->assertEquals('62000', self::$object->getCodeInsee());

        self::$object->setCodeInsee('62001');

        $this->assertEquals('62001', self::$object->getCodeInsee());
        $this->assertInternalType('string', self::$object->getCodeInsee());
    }
}
