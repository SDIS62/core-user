<?php

namespace SDIS62\Core\User\Repository;

use SDIS62\Core\User\Entity\Profile;

interface ProfileRepositoryInterface
{
    /**
     * Retourne un profil correspondant à l'id spécifié
     *
     * @param  int                             $id_profile
     * @return SDIS62\Core\User\Entity\Profile
     */
    public function find($id_profile);

    /**
     * Retourne les profils d'un utilisateur
     *
     * @param  int                               $id_user
     * @return SDIS62\Core\User\Entity\Profile[]
     */
    public function findAllByUser($id_user);

    /**
     * Sauvegarde d'un profil
     *
     * @param  SDIS62\Core\User\Entity\Profile
     */
    public function save(Profile & $profile);

    /**
     * Suppression d'un profil
     *
     * @param  SDIS62\Core\User\Entity\Profile
     */
    public function delete(Profile & $profile);
}
