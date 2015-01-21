<?php

namespace SDIS62\Core\User\Entity\Profile;

use SDIS62\Core\User\Entity\User;
use SDIS62\Core\User\Entity\Profile;

class MaireProfile extends Profile
{
    /**
     * Type du profil
     *
     * @var string
     */
    protected $type = 'maire';

    /**
     * code insee de la commune du maire
     *
     * @var string
     */
    protected $code_insee;

    /*
    * Constructeur
    *
    * @param SDIS62\Core\User\Entity\User $user
    * @param string code insee
    */
    public function __construct(User $user, $code_insee)
    {
        $this->setCodeInsee($code_insee);

        parent::__construct($user);
    }

    /**
     * Get the value of code insee de la commune du maire
     *
     * @return string
     */
    public function getCodeInsee()
    {
        return $this->code_insee;
    }

    /**
     * Set the value of code insee de la commune du maire
     *
     * @param string code_insee
     *
     * @return self
     */
    public function setCodeInsee($value)
    {
        $this->code_insee = $value;

        return $this;
    }
}
