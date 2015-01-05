<?php

namespace SDIS62\Core\User\Entity\Profile\Sdis;

use SDIS62\Core\User\Entity\Grade;
use SDIS62\Core\User\Entity\Profile\SdisProfile;
use SDIS62\Core\User\Entity\Grade\TechniqueGrade;
use SDIS62\Core\User\Exception\InvalidGradeException;

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
     * @param SDIS62\Core\User\Entity\Grade grade
     * @throws InvalidGradeException Si le grade donné n'est pas compatible avec le profil
     *
     * @return self
     */
    public function setGrade(Grade $value)
    {
        if (! $value instanceof TechniqueGrade) {
            throw new InvalidGradeException('Un personnel technique ne peut qu\'avoir un grade de type technique.');
        }

        $this->grade = $value;

        return $this;
    }
}
