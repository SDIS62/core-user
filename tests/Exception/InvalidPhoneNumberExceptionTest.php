<?php

namespace SDIS62\Core\User\Test\Exception;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class InvalidPhoneNumberExceptionTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Exception\InvalidPhoneNumberException();
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('\Exception', self::$object);
    }
}
