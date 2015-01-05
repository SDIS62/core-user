<?php

namespace SDIS62\Core\User\Entity\Profile;

use SDIS62\Core\User\Entity\Profile;
use SDIS62\Core\User\Entity\Grade;

abstract class SdisProfile extends Profile
{
    /**
     * Grade
     *
     * @var SDIS62\Core\User\Entity\Grade
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
    * @param SDIS62\Core\User\Entity\Grade $grade
    * @param string $poste
    */
    public function __construct(Grade $grade, $poste)
    {
        $this->grade = $grade;
        $this->poste = $poste;
    }

    /**
     * Get the value of Grade
     *
     * @return SDIS62\Core\User\Entity\Grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set the value of Grade
     *
     * @param SDIS62\Core\User\Entity\Grade grade
     *
     * @return self
     */
    public function setGrade(Grade $value)
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
