<?php

namespace SDIS62\Core\User\Service;

use SDIS62\Core\User\Entity\User;
use SDIS62\Core\User\Repository\UserRepositoryInterface;

class UserService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\User\Repository\UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * Sauvegarde d'un utilisateur (insert et update si un id est présent)
     *
     * <code>
     * $array = array(
     *     'gender' => 'male',
     *     'first_name' => 'Kevin',
     *     'last_name' => 'DUBUC',
     *     'email' => 'kdubuc@sdis62.fr',
     *     'birthday' => '14-08-1988',
     *     'picture_url' => 'http://www.sdis62.fr/avatar.jpg'
     * );
     * </code>
     *
     * @param  array                        $data Tableau des données de l'utilisateur
     * @return SDIS62\Core\User\Entity\User
     */
    public function save(array $data)
    {
        $user = empty($data['id']) ? new User($data['gender'], $data['first_name'], $data['last_name'], $data['email']) : $this->find($data["id"]);

        if (!empty($data['first_name'])) {
            $user->setFirstName($data['first_name']);
        }

        if (!empty($data['last_name'])) {
            $user->setLastName($data['last_name']);
        }

        if (!empty($data['gender'])) {
            $user->setGender($data['gender']);
        }

        if (!empty($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (!empty($data['birthday'])) {
            $user->setBirthday($data['birthday']);
        }

        if (!empty($data['picture_url'])) {
            $user->setPictureUrl($data['picture_url']);
        }

        if (!empty($data['email'])) {
            $user->setEmail($data['email']);
        }

        $this->user_repository->save($user);

        return $user;
    }

    /**
     * Suppression d'un utilisateur
     *
     * @param int $id_user
     */
    public function delete($id_user)
    {
        $user = $this->find($id_user);
        $this->user_repository->delete($user);
    }

    /**
     * Récupération de l'ensemble des utilisateurs
     *
     * @return SDIS62\Core\User\Entity\User[]
     */
    public function getAll()
    {
        return $this->user_repository->getAll();
    }

    /**
     * Récupération de l'utilisateur à l'id spécifié
     *
     * @param  int                          $id_user
     * @return SDIS62\Core\User\Entity\User
     */
    public function find($id_user)
    {
        return $this->user_repository->find($id_user);
    }

    /**
     * Récupération de l'utilisateur correspondant à l'email
     *
     * @param  string                       $email
     * @return SDIS62\Core\User\Entity\User
     */
    public function findByEmail($email)
    {
        return $this->user_repository->findByEmail($email);
    }
}
