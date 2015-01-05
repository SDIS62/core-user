<?php

namespace SDIS62\Core\User\Entity\Profile\Sdis;

use SDIS62\Core\User\Entity\Profile\SdisProfile;
use SDIS62\Core\User\Entity\Grade\AdministratifGrade;

class PersonnelAdministratifSdisProfile extends SdisProfile
{
    /**
     * Type du profil
     *
     * @var string
     */
    protected $type = 'personnel_administratif';

    /*
    * Constructeur
    *
    * @param SDIS62\Core\User\Entity\Grade\AdministratifGrade $grade
    * @param string $poste
    */
    public function __construct(AdministratifGrade $grade, $poste)
    {
        $this->grade = $grade;
        $this->poste = $poste;
    }

    /**
     * Set the value of Grade
     *
     * @param SDIS62\Core\User\Entity\Grade\AdministratifGrade grade
     *
     * @return self
     */
    public function setGrade(AdministratifGrade $value)
    {
        $this->grade = $value;

        return $this;
    }
}
