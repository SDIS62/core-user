<?php

namespace SDIS62\Core\User\Entity;

use Mockery;
use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class ProfileTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $mock = Mockery::mock('SDIS62\Core\User\Entity\Profile')->makePartial();

        self::$object = $mock;
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_have_a_phone_number()
    {
        self::$object->setPhoneNumber('0321212121');

        $this->assertEquals('03 21 21 21 21', self::$object->getPhoneNumber());
        $this->assertInternalType('string', self::$object->getPhoneNumber());
    }

    public function test_if_it_throw_an_exception_if_phone_number_is_not_valid()
    {
        try {
            self::$object->setPhoneNumber('0321');
        } catch (Core\Exception\InvalidPhoneNumberException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_throw_an_exception_if_profile_is_not_valid()
    {
        try {
            self::$object->getType();
        } catch (Core\Exception\InvalidProfileException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }
}
