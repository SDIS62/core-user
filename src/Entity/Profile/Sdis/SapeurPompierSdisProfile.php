<?php

namespace SDIS62\Core\User\Entity\Profile\Sdis;

use SDIS62\Core\User\Entity\User;
use SDIS62\Core\User\Entity\Profile\SdisProfile;

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
    * @param SDIS62\Core\User\Entity\User $user
    * @param Sstring $grade
    * @param string $poste
    * @param bool $pro Optionnel
    */
    public function __construct(User $user, $grade, $poste, $pro = false)
    {
        $this->is_pro = $pro;

        parent::__construct($user, $grade, $poste);
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
