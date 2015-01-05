<?php

namespace SDIS62\Core\User\Entity\Profile\Sdis;

use SDIS62\Core\User\Entity\Grade;
use SDIS62\Core\User\Entity\Profile\SdisProfile;
use SDIS62\Core\User\Entity\Grade\AdministratifGrade;
use SDIS62\Core\User\Exception\InvalidGradeException;

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
     * @param SDIS62\Core\User\Entity\Grade grade
     * @throws InvalidGradeException Si le grade donné n'est pas compatible avec le profil
     *
     * @return self
     */
    public function setGrade(Grade $value)
    {
        if (! $value instanceof AdministratifGrade) {
            throw new InvalidGradeException('Un personnel administratif ne peut qu\'avoir un grade de type administratif.');
        }

        $this->grade = $value;

        return $this;
    }
}
