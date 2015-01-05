<?php

namespace SDIS62\Core\User\Entity;

use SDIS62\Core\Common\Entity\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use SDIS62\Core\User\Exception\InvalidGenderException;
use SDIS62\Core\User\Exception\InvalidPictureUrlException;
use SDIS62\Core\User\Exception\InvalidEmailAddressException;

class User
{
    use IdentityTrait;

    /**
     * Prénom de l'utilisateur
     *
     * @var string
     */
    protected $first_name;

    /**
     * Nom de l'utilisateur
     *
     * @var string
     */
    protected $last_name;

    /**
     * Sexe de l'utilisateur
     *
     * @var string
     */
    protected $gender;

    /**
     * Date de naissance
     *
     * @var \DateTime|null
     */
    protected $birthday;

    /**
     * URL de l'avatar de l'utilisateur
     *
     * @var string|null
     */
    private $profile_pic_url;

    /**
     * Email
     *
     * @var string|null
     */
    private $email;

    /**
     * Profils liés à l'utilisateur
     *
     * @var SDIS62\Core\User\Entity\Profile[]
     */
    protected $profiles;

    /*
     * Constructeur
     *
     * @param string $gender
     * @param string $first_name Prénom de l'utilisateur
     * @param string $last_name  Nom de l'utilisateur
     * @param string $email      Mail de l'utilisateur
     */
    public function __construct($gender, $first_name, $last_name, $email)
    {
        $this->setGender($gender);
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setEmail($email);

        $this->profiles = new ArrayCollection();
    }

    /**
     * Get the value of Prénom de l'utilisateur
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set the value of Prénom de l'utilisateur
     *
     * @param string first_name
     *
     * @return self
     */
    public function setFirstName($first_name)
    {
        $first_name = ucwords(strtolower((string) $first_name));
        $first_name = str_replace(' ', '-', $first_name);
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of Nom de l'utilisateur
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the value of Nom de l'utilisateur
     *
     * @param string last_name
     *
     * @return self
     */
    public function setLastName($last_name)
    {
        $this->last_name = strtoupper((string) $last_name);

        return $this;
    }

    /**
     * Récupération du nom complet
     *
     * @return string
     */
    public function getFullName()
    {
        $detect_spp_profile = function ($key, $profile) {
            return $profile instanceof Profile\Sdis\SapeurPompierSdisProfile && $profile->isPro();
        };

        if ($this->getProfiles()->exists($detect_spp_profile)) {
            $profiles = $this->getProfiles()->toArray();
            $prefix = prev($profiles)->getGrade()->getLabel().' ';
        } else {
            $prefix = '';
        }

        return $prefix.$this->getLastName().' '.$this->getFirstName();
    }

    /**
     * Get the value of Sexe de l'utilisateur
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of Sexe de l'utilisateur
     *
     * @param string gender
     * @throws InvalidGenderException
     *
     * @return self
     */
    public function setGender($gender)
    {
        if ($gender !== 'male' && $gender !== 'female') {
            throw new InvalidGenderException("Mauvais sexe affecté à l'utilisateur");
        }

        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of Date de naissance
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set the value of Date de naissance. SI le paramètre est une chaine de caractère,
     * la date doit correspondre au format Y-m-d.
     *
     * @param \DateTime|string|null birthday
     *
     * @return self
     */
    public function setBirthday($birthday)
    {
        if ($birthday instanceof \Datetime) {
            $this->birthday = $birthday;
        } elseif ($birthday === null) {
            $this->birthday = null;
        } else {
            $this->birthday = \DateTime::createFromFormat('d-m-Y', (string) $birthday);
        }

        return $this;
    }

    /**
     * Récupération de l'age de l'utilisateur
     *
     * @return int|null
     */
    public function getAge()
    {
        if ($this->getBirthday() === null) {
            return;
        }

        $now = new \DateTime();
        $age = $this->getBirthday()->diff($now);

        return $age->y;
    }

    /**
     * Get the value of URL de l'avatar de l'utilisateur
     *
     * @return string|null
     */
    public function getPictureUrl()
    {
        return $this->profile_pic_url;
    }

    /**
     * Set the value of URL de l'avatar de l'utilisateur
     *
     * @param string|null profile_pic_url
     *
     * @return self
     */
    public function setPictureUrl($profile_pic_url)
    {
        if (!filter_var($profile_pic_url, FILTER_VALIDATE_URL)) {
            throw new InvalidPictureUrlException("URL incorrecte.");
        }

        $this->profile_pic_url = (string) strtolower($profile_pic_url);

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param string|null email
     * @throws InvalidEmailAddressException
     *
     * @return self
     */
    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressException("Email incorrect.");
        }

        $this->email = (string) strtolower($email);

        return $this;
    }

    /**
     * Récupération de la liste des profils
     *
     * @return SDIS62\Core\User\Entity\Profile[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * Ajoute un profil à l'utilisateur
     *
     * @param  SDIS62\Core\User\Entity\Profile $profile
     * @return self
     */
    public function addProfile(Profile $profile)
    {
        $this->profiles[] = $profile;

        return $this;
    }

    /**
     * Ajoute un ensemble de profils
     *
     * @param  SDIS62\Core\User\Entity\Profile[] $profiles
     * @return self
     */
    public function setProfiles($profiles)
    {
        $this->profiles->clear();

        foreach ($profiles as $profile) {
            $this->addProfile($profile);
        }

        return $this;
    }
}
