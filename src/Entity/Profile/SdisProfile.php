<?php

namespace SDIS62\Core\User\Entity\Profile;

use SDIS62\Core\User\Entity\User;
use SDIS62\Core\User\Entity\Profile;

abstract class SdisProfile extends Profile
{
    /**
     * Grade
     *
     * @var string
     */
    protected $grade;

    /**
     * Poste
     *
     * @var string
     */
    protected $poste;

    /*
    * Constructeur
    *
    * @param SDIS62\Core\User\Entity\User $user
    * @param string $grade
    * @param string $poste
    */
    public function __construct(User $user, $grade, $poste)
    {
        $this->grade = $grade;
        $this->poste = $poste;

        parent::__construct($user);
    }

    /**
     * Get the value of Grade
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Change le grade associé au profil
     *
     * @param string grade
     *
     * @return self
     */
    public function promote($value)
    {
        $this->grade = $value;

        return $this;
    }

    /**
     * Get the value of Poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set the value of Poste
     *
     * @param string poste
     *
     * @return self
     */
    public function setPoste($value)
    {
        $this->poste = $value;

        return $this;
    }
}
