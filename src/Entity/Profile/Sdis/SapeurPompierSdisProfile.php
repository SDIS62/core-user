<?php

namespace SDIS62\Core\User\Entity\Profile\Sdis;

use SDIS62\Core\User\Entity\Grade;
use SDIS62\Core\User\Entity\Profile\SdisProfile;
use SDIS62\Core\User\Entity\Grade\SapeurPompierGrade;
use SDIS62\Core\User\Exception\InvalidGradeException;

class SapeurPompierSdisProfile extends SdisProfile
{
    /**
     * Type du profil
     *
     * @var string
     */
    protected $type = 'sapeur_pompier';

    /**
     * Pro ou volontaire ?
     *
     * @var bool
     */
    protected $is_pro;

    /*
    * Constructeur
    *
    * @param SDIS62\Core\User\Entity\Grade\SapeurPompierGrade $grade
    * @param string $poste
    */
    public function __construct(SapeurPompierGrade $grade, $poste, $pro = false)
    {
        $this->is_pro = $pro;
        parent::__construct($grade, $poste);
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
        if (! $value instanceof SapeurPompierGrade) {
            throw new InvalidGradeException('Un sapeur pompier ne peut qu\'avoir un grade de type sapeur pompier.');
        }

        $this->grade = $value;

        return $this;
    }

    /**
     * Get the value of Pro ou volontaire ?
     *
     * @return bool
     */
    public function isPro()
    {
        return $this->is_pro == true;
    }

    /**
     * Set the value of Pro ou volontaire ?
     *
     * @param bool is_pro
     *
     * @return self
     */
    public function setPro($value = true)
    {
        $this->is_pro = $value == true;

        return $this;
    }
}
