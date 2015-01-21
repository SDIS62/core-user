<?php

namespace SDIS62\Core\User\Test\Service;

use Mockery;
use Datetime;
use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class UserServiceTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $user1 = new Core\Entity\User('male', 'Kevin', 'Dubuc', 'kdubuc@sdis62.fr');
        $user2 = new Core\Entity\User('female', 'Kelly', 'Billet', 'kbillet@sdis62.fr');

        $user1->setId(1);
        $user2->setId(2);

        $repository_user_mock = Mockery::mock('SDIS62\Core\User\Repository\UserRepositoryInterface');
        $repository_user_mock->shouldReceive('getAll')->andReturn(array($user1, $user2));
        $repository_user_mock->shouldReceive('find')->with(1)->andReturn($user1);
        $repository_user_mock->shouldReceive('find')->with(2)->andReturn($user2);
        $repository_user_mock->shouldReceive('findByEmail')->with('kdubuc@sdis62.fr')->andReturn($user1);
        $repository_user_mock->shouldReceive('save');
        $repository_user_mock->shouldReceive('delete');

        self::$object = new Core\Service\UserService($repository_user_mock);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Service\UserService', self::$object);
    }

    public function test_if_it_find()
    {
        $this->assertEquals(2, self::$object->find(2)->getId());
    }

    public function test_if_it_get_all()
    {
        $this->assertCount(2, self::$object->getAll());
    }

    public function test_if_it_find_by_email()
    {
        $this->assertEquals(1, self::$object->findByEmail('kdubuc@sdis62.fr')->getId());
    }

    public function test_if_it_save()
    {
        $user_informations = array(
            'gender' => 'male',
            'first_name' => 'Kevin',
            'last_name' => 'DUBUC',
            'email' => 'kdubuc@sdis62.fr',
            'birthday' => '14-08-1988',
            'picture_url' => 'http://www.sdis62.fr/avatar.jpg',
        );

        $date = Datetime::createFromFormat('d-m-Y', $user_informations['birthday']);

        $user = self::$object->save($user_informations);

        $this->assertEquals($date, $user->getBirthday());
        $this->assertEquals($user_informations['gender'], $user->getGender());
        $this->assertEquals($user_informations['first_name'], $user->getFirstName());
        $this->assertEquals($user_informations['last_name'], $user->getLastName());
        $this->assertEquals($user_informations['email'], $user->getEmail());
        $this->assertEquals($user_informations['picture_url'], $user->getPictureUrl());
    }

    public function test_if_it_delete()
    {
        self::$object->delete(2);
    }
}
