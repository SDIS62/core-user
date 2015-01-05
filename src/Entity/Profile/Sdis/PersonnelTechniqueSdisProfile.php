<?php

namespace SDIS62\Core\User\Entity\Profile\Sdis;

use SDIS62\Core\User\Entity\Profile\SdisProfile;
use SDIS62\Core\User\Entity\Grade\TechniqueGrade;

class PersonnelTechniqueSdisProfile extends SdisProfile
{
    /**
     * Type du profil
     *
     * @var string
     */
    protected $type = 'personnel_technique';

    /*
    * Constructeur
    *
    * @param SDIS62\Core\User\Entity\Grade\TechniqueGrade $grade
    * @param string $poste
    */
    public function __construct(TechniqueGrade $grade, $poste)
    {
        $this->grade = $grade;
        $this->poste = $poste;
    }

    /**
     * Set the value of Grade
     *
     * @param SDIS62\Core\User\Entity\Grade\TechniqueGrade grade
     *
     * @return self
     */
    public function setGrade(TechniqueGrade $value)
    {
        $this->grade = $value;

        return $this;
    }
}
