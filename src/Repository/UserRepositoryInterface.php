<?php

namespace SDIS62\Core\User\Repository;

use SDIS62\Core\User\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Retourne un ensemble d'utilisateurs
     *
     * @return SDIS62\Core\User\Entity\User[]
     */
    public function getAll();

    /**
     * Retourne un utilisateur correspondant à l'id spécifié
     *
     * @param  int                          $id
     * @return SDIS62\Core\User\Entity\User
     */
    public function find($id_user);

    /**
     * Retourne un utilisateur correspondant à l'email spécifié
     *
     * @param  string                       $email
     * @return SDIS62\Core\User\Entity\User
     */
    public function findByEmail($email);

    /**
     * Sauvegarde d'un utilisateur
     *
     * @param  SDIS62\Core\User\Entity\User
     */
    public function save(User & $user);

    /**
     * Suppression d'un utilisateur
     *
     * @param  SDIS62\Core\User\Entity\User
     */
    public function delete(User & $user);
}
