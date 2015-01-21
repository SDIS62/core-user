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

        $grade_sp = new Core\Entity\Grade\SapeurPompierGrade('Lieutenant', 10);
        $grade_administratif = new Core\Entity\Grade\AdministratifGrade('Redacteur', 10);
        $grade_technique = new Core\Entity\Grade\TechniqueGrade('Ingenieur', 10);

        $grade_sp->setId(1);
        $grade_administratif->setId(2);
        $grade_technique->setId(3);

        $repository_grade_mock = Mockery::mock('SDIS62\Core\User\Repository\GradeRepositoryInterface');
        $repository_grade_mock->shouldReceive('getAll')->andReturn(array($grade_sp));
        $repository_grade_mock->shouldReceive('find')->with(1)->andReturn($grade_sp);
        $repository_grade_mock->shouldReceive('find')->with(2)->andReturn($grade_administratif);
        $repository_grade_mock->shouldReceive('find')->with(3)->andReturn($grade_technique);
        $repository_grade_mock->shouldReceive('save');
        $repository_grade_mock->shouldReceive('delete');

        $profile1 = new Core\Entity\Profile\MaireProfile('62001');
        $profile2 = new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile($grade_administratif, 'Paie');
        $profile3 = new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile($grade_technique, 'Dev');
        $profile4 = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($grade_sp, 'Pompier en caserne');

        $profile1->setId(1);
        $profile2->setId(2);
        $profile3->setId(3);
        $profile4->setId(4);

        $repository_profile_mock = Mockery::mock('SDIS62\Core\User\Repository\ProfileRepositoryInterface');
        $repository_profile_mock->shouldReceive('find')->with(1)->andReturn($profile1);
        $repository_profile_mock->shouldReceive('find')->with(2)->andReturn($profile2);
        $repository_profile_mock->shouldReceive('find')->with(3)->andReturn($profile3);
        $repository_profile_mock->shouldReceive('find')->with(4)->andReturn($profile4);
        $repository_profile_mock->shouldReceive('save');
        $repository_profile_mock->shouldReceive('delete');

        self::$object = new Core\Service\UserService($repository_user_mock, $repository_profile_mock, $repository_grade_mock);
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
            'profiles' => array(
                array('type' => 'maire', 'code_insee' => '62000'),
                array('type' => 'sapeur_pompier', 'grade' => array('id' => 1), 'poste' => 'Sapeur', 'pro' => true),
                array('type' => 'personnel_administratif', 'grade' => array('id' => 2), 'poste' => 'Chef de service'),
                array('type' => 'personnel_technique', 'grade' => array('id' => 3), 'poste' => 'Developpeur'),
                array('id' => 1, 'code_insee' => '62002'),
                array('id' => 2, 'grade' => array('type' => 'administratif', 'label' => 'Grade admn', 'value' => 10), 'poste' => 'chef finance'),
                array('id' => 4, 'grade' => array('type' => 'sapeur_pompier', 'label' => 'Sapeur', 'value' => 10), 'pro' => true),
                array('id' => 4, 'grade' => array('type' => 'sapeur_pompier', 'label' => 'Sapeur', 'value' => 10)),
                array('id' => 3, 'grade' => array('type' => 'technique', 'label' => 'Inge principal', 'value' => 10)),
                array('id' => 4, 'grade' => array('id' => 1, 'value' => 10, 'label' => 'Premiere classe')),
            ),
        );

        $date = Datetime::createFromFormat('d-m-Y', $user_informations['birthday']);

        $user = self::$object->save($user_informations);

        $this->assertEquals($date, $user->getBirthday());
        $this->assertEquals($user_informations['gender'], $user->getGender());
        $this->assertEquals($user_informations['first_name'], $user->getFirstName());
        $this->assertEquals($user_informations['last_name'], $user->getLastName());
        $this->assertEquals($user_informations['email'], $user->getEmail());
        $this->assertEquals($user_informations['picture_url'], $user->getPictureUrl());

        $this->assertCount(10, $user->getProfiles());

        $grade_sp = new Core\Entity\Grade\SapeurPompierGrade('Premiere classe', 10);
        $grade_administratif = new Core\Entity\Grade\AdministratifGrade('Redacteur', 10);
        $grade_technique = new Core\Entity\Grade\TechniqueGrade('Ingenieur', 10);
        $grade_sp->setId(1);
        $grade_administratif->setId(2);
        $grade_technique->setId(3);

        $this->assertEquals(new Core\Entity\Profile\MaireProfile('62000'), $user->getProfiles()[0]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($grade_sp, 'Sapeur', true), $user->getProfiles()[1]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile($grade_administratif, 'Chef de service'), $user->getProfiles()[2]);
        $this->assertEquals(new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile($grade_technique, 'Developpeur'), $user->getProfiles()[3]);

        $profile1 = new Core\Entity\Profile\MaireProfile('62002');
        $profile2 = new Core\Entity\Profile\Sdis\PersonnelAdministratifSdisProfile(new Core\Entity\Grade\AdministratifGrade('Grade admn', 10), 'chef finance');
        $profile3 = new Core\Entity\Profile\Sdis\PersonnelTechniqueSdisProfile(new Core\Entity\Grade\TechniqueGrade('Inge principal', 10), 'Dev');
        $profile4 = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($grade_sp, 'Pompier en caserne', true);
        $profile1->setId(1);
        $profile2->setId(2);
        $profile3->setId(3);
        $profile4->setId(4);

        $this->assertEquals($profile1, $user->getProfiles()[4]);
        $this->assertEquals($profile2, $user->getProfiles()[5]);
        $this->assertEquals($profile4, $user->getProfiles()[6]);
        $this->assertEquals($profile4, $user->getProfiles()[7]);
        $this->assertEquals($profile3, $user->getProfiles()[8]);
        $this->assertEquals($profile4, $user->getProfiles()[9]);

        $user_informations = array(
            'gender' => 'male',
            'first_name' => 'Kevin',
            'last_name' => 'DUBUC',
            'email' => 'kdubuc@sdis62.fr',
            'profiles' => array(
                array('type' => 'maire', 'code_insee' => '62000'),
            ),
        );

        $user = self::$object->save($user_informations);

        $this->assertCount(1, $user->getProfiles());
    }

    public function test_if_it_throw_an_exception_if_incorrect_save_values_are_provided()
    {
        try {
            $incorrect_user_informations = array(
                'id' => 1,
                'profiles' => array(
                    array('type' => 'dsdsfsd', 'code_insee' => '62000'),
                ),
            );
            $user = self::$object->save($incorrect_user_informations);
        } catch (Core\Exception\InvalidProfileException $e) {
        }

        try {
            $incorrect_user_informations = array(
                'id' => 1,
                'profiles' => array(
                    array('type' => 'sapeur_pompier', 'grade' => array('type' => 'lknfsl')),
                ),
            );
            $user = self::$object->save($incorrect_user_informations);
        } catch (Core\Exception\InvalidGradeException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_delete()
    {
        self::$object->delete(2);
    }
}
