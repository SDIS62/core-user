<?php

namespace SDIS62\Core\User\Entity;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use SDIS62\Core\Common\Entity\IdentityTrait;
use SDIS62\Core\User\Exception\InvalidProfileException;
use SDIS62\Core\User\Exception\InvalidPhoneNumberException;

abstract class Profile
{
    use IdentityTrait;

    /**
     * Type du profil
     *
     * @var string
     */
    protected $phone_number;

    /**
     * Get the value of Type du profil
     *
     * @return string
     */
    final public function getType()
    {
        if (empty($this->type)) {
            throw new InvalidProfileException(get_class($this).' doit avoir un $type');
        }

        return $this->type;
    }

    /**
     * Get the value of Numéro de téléphone concernant le profil
     *
     * @return \DateTime|null
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set the value of Numéro de téléphone concernant le profil
     *
     * @param string|null professional_phone_number
     * @throws InvalidPhoneNumberException
     *
     * @return self
     */
    public function setPhoneNumber($phone_number)
    {
        $phone_util = PhoneNumberUtil::getInstance();
        $phone_number_parsed = $phone_util->parse($phone_number, "FR");

        if (!$phone_util->isValidNumber($phone_number_parsed)) {
            throw new InvalidPhoneNumberException("Format du numéro de téléphone professionnel incorrect.");
        }

        $this->phone_number = $phone_util->format($phone_number_parsed, PhoneNumberFormat::NATIONAL);

        return $this;
    }
}
