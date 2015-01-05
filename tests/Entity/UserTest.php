<?php

namespace SDIS62\Core\User\Entity;

use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $gender = "male";
        $first_name = "jean francois";
        $last_name = "dubuC";
        $email = "kdubuc@sdis62.fr";

        self::$object = new Core\Entity\User($gender, $first_name, $last_name, $email);
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Entity\User', self::$object);
    }

    public function test_if_it_throw_an_exception_if_email_is_not_valid()
    {
        try {
            self::$object->setEmail('foo@bar');
        } catch (Core\Exception\InvalidEmailAddressException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_have_a_gender()
    {
        $this->assertEquals('male', self::$object->getGender());
        $this->assertInternalType('string', self::$object->getGender());
    }

    public function test_if_it_throw_an_exception_if_gender_is_not_valid()
    {
        try {
            self::$object->setGender('foo');
        } catch (Core\Exception\InvalidGenderException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_have_a_lastname()
    {
        $this->assertEquals('DUBUC', self::$object->getLastName());
        $this->assertInternalType('string', self::$object->getLastName());
    }

    public function test_if_it_have_a_firstname()
    {
        $this->assertEquals('Jean-Francois', self::$object->getFirstName());
        $this->assertInternalType('string', self::$object->getFirstName());
    }

    public function test_if_it_have_a_fullname()
    {
        $this->assertEquals('DUBUC Jean-Francois', self::$object->getFullName());
        $this->assertInternalType('string', self::$object->getFullName());
    }

    public function test_if_it_have_a_fullname_prefixed_with_the_spp_profile()
    {
        $profile_spv = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile(new Core\Entity\Grade\SapeurPompierGrade('Lieutenant', 10), 'Directeur');
        $profile_spp = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile(new Core\Entity\Grade\SapeurPompierGrade('Colonel', 10), 'Directeur', true);

        self::$object->addProfile($profile_spv);
        self::$object->addProfile($profile_spv);
        self::$object->addProfile($profile_spp);
        self::$object->addProfile($profile_spv);

        $this->assertEquals('Colonel DUBUC Jean-Francois', self::$object->getFullName());
        $this->assertInternalType('string', self::$object->getFullName());
    }

    public function test_if_it_have_an_email()
    {
        $this->assertEquals('kdubuc@sdis62.fr', self::$object->getEmail());
        $this->assertInternalType('string', self::$object->getEmail());
    }

    public function test_if_it_have_a_birthday_datetime()
    {
        $this->assertNull(self::$object->getBirthday());

        self::$object->setBirthday('14-08-1988');

        $this->assertInstanceOf('Datetime', self::$object->getBirthday());
        $this->assertEquals('14', date_format(self::$object->getBirthday(), 'd'));
        $this->assertEquals('08', date_format(self::$object->getBirthday(), 'm'));
        $this->assertEquals('1988', date_format(self::$object->getBirthday(), 'Y'));

        self::$object->setBirthday(\DateTime::createFromFormat('d-m-Y', '14-08-1988'));

        $this->assertInstanceOf('Datetime', self::$object->getBirthday());
        $this->assertEquals('14', date_format(self::$object->getBirthday(), 'd'));
        $this->assertEquals('08', date_format(self::$object->getBirthday(), 'm'));
        $this->assertEquals('1988', date_format(self::$object->getBirthday(), 'Y'));

        self::$object->setBirthday(null);

        $this->assertNull(self::$object->getBirthday());
    }

    public function test_if_it_have_an_age_when_birthday_is_setted()
    {
        $now = new \DateTime();
        $birthday_date_raw = "14-08-1988";
        $birthday_date_with_datetime_object = \DateTime::createFromFormat('d-m-Y', '14-08-1988');
        $age = $birthday_date_with_datetime_object->diff($now);

        $this->assertNull(self::$object->getAge());

        self::$object->setBirthday($birthday_date_raw);

        $this->assertEquals($age->y, self::$object->getAge());
        $this->assertInternalType('int', self::$object->getAge());
    }

    public function test_if_it_have_a_picture()
    {
        self::$object->setPictureUrl('http://images.sdis62.fr/avatar.jpg');

        $this->assertEquals('http://images.sdis62.fr/avatar.jpg', self::$object->getPictureUrl());
        $this->assertInternalType('string', self::$object->getPictureUrl());
    }

    public function test_if_it_throw_an_exception_if_picture_url_is_not_valid()
    {
        try {
            self::$object->setPictureUrl('foo');
        } catch (Core\Exception\InvalidPictureUrlException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_can_set_profiles()
    {
        $grade = new Core\Entity\Grade\SapeurPompierGrade('Colonel', 10);

        $profile_spv = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($grade, 'Directeur');
        $profile_spp = new Core\Entity\Profile\Sdis\SapeurPompierSdisProfile($grade, 'Directeur', true);

        self::$object->setProfiles(array($profile_spv, $profile_spp));

        $this->assertCount(2, self::$object->getProfiles());

        self::$object->setProfiles(array($profile_spp));

        $this->assertCount(1, self::$object->getProfiles());
        $this->assertNull(self::$object->getProfiles()[1]);
        $this->assertEquals($profile_spp, self::$object->getProfiles()[0]);
    }
}
