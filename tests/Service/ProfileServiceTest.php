<?php

namespace SDIS62\Core\User\Test\Service;

use Mockery;
use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class ProfileServiceTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $user1 = new Core\Entity\User('male', 'Kevin', 'Dubuc', 'kdubuc@sdis62.fr');
        $user2 = new Core\Entity\User('female', 'Kelly', 'Billet', 'kbillet@sdis62.fr');

        $repository_user_mock = Mockery::mock('SDIS62\Core\User\Repository\UserRepositoryInterface');
        $repository_user_mock->shouldReceive('getAll')->andReturn(array($user1, $user2));
        $repository_user_mock->shouldReceive('find')->with(1)->andReturn($user1);
        $repository_user_mock->shouldReceive('find')->with(2)->andReturn($user2);
        $repository_user_mock->shouldReceive('findByEmail')->with('kdubuc@sdis62.fr')->andReturn($user1);
        $repository_user_mock->shouldReceive('save');
        $repository_user_mock->shouldReceive('delete');

        $profile1 = new Core\Entity\Profile\MaireProfile($user1, '62001');
        $profile2 = new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile($user1, 'grade administratif', 'Paie');
        $profile3 = new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile($user1, 'grade technique', 'Dev');
        $profile4 = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($user1, 'grade sp', 'Pompier en caserne');

        $repository_profile_mock = Mockery::mock('SDIS62\Core\User\Repository\ProfileRepositoryInterface');
        $repository_profile_mock->shouldReceive('find')->with(1)->andReturn($profile1);
        $repository_profile_mock->shouldReceive('find')->with(2)->andReturn($profile2);
        $repository_profile_mock->shouldReceive('find')->with(3)->andReturn($profile3);
        $repository_profile_mock->shouldReceive('find')->with(4)->andReturn($profile4);
        $repository_profile_mock->shouldReceive('findAllByUser')->with(1)->andReturn(array($profile1, $profile2, $profile3, $profile4));
        $repository_profile_mock->shouldReceive('save');
        $repository_profile_mock->shouldReceive('delete');

        self::$object = new Core\Service\ProfileService($repository_profile_mock, $repository_user_mock);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Service\ProfileService', self::$object);
    }

    public function test_if_it_find()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile', self::$object->find(2));
    }

    public function test_if_it_find_all_by_user()
    {
        $this->assertCount(4, self::$object->findAllByUser(1));
    }

    public function test_if_it_save()
    {
        $profiles_informations = array(
            array('user' => 1, 'type' => 'maire', 'code_insee' => '62000'),
            array('user' => 1, 'type' => 'sapeur_pompier', 'grade' => 'Sapeur', 'poste' => 'Poste Sapeur', 'pro' => true),
            array('user' => 1, 'type' => 'personnel_administratif', 'grade' => 'Grade administratif', 'poste' => 'Chef de service'),
            array('user' => 1, 'type' => 'personnel_technique', 'grade' => 'Grade technique', 'poste' => 'Developpeur'),
            array('id' => 1, 'code_insee' => '62002'),
            array('id' => 2, 'grade' => 'Grade administratif', 'poste' => 'chef finance'),
            array('id' => 4, 'grade' => 'sapeur', 'pro' => true),
            array('id' => 4, 'poste' => 'sapeur'),
            array('id' => 3, 'grade' => 'ingenieur principal'),
            array('id' => 4, 'grade' => 'premiere classe'),
        );

        foreach ($profiles_informations as $profile_informations) {
            $profile = self::$object->save($profile_informations);
        }

        $user = $profile->getUser();
        $user_tmp = clone $user;

        $this->assertCount(8, $profile->getUser()->getProfiles());

        $this->assertEquals(new Core\Entity\Profile\MaireProfile($user_tmp, '62002'), $user->getProfiles()[0]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile($user_tmp, 'Grade administratif', 'chef finance'), $user->getProfiles()[1]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile($user_tmp, 'ingenieur principal', 'Dev'), $user->getProfiles()[2]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($user_tmp, 'premiere classe', 'sapeur', true), $user->getProfiles()[3]);
        $this->assertEquals(new Core\Entity\Profile\MaireProfile($user_tmp, '62000'), $user->getProfiles()[4]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($user_tmp, 'Sapeur', 'Poste Sapeur', true), $user->getProfiles()[5]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile($user_tmp, 'Grade administratif', 'Chef de service'), $user->getProfiles()[6]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile($user_tmp, 'Grade technique', 'Developpeur'), $user->getProfiles()[7]);
    }

    public function test_if_it_throw_an_exception_if_incorrect_save_values_are_provided()
    {
        try {
            $incorrect_profile_informations = array(
                'type' => 'dsdsfsd',
                'code_insee' => '62000',
            );
            $user = self::$object->save($incorrect_profile_informations);
        } catch (Core\Exception\InvalidProfileException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_delete()
    {
        self::$object->delete(2);
    }
}
