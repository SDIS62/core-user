<?php

namespace SDIS62\Core\User\Service;

use SDIS62\Core\User\Entity\User;
use SDIS62\Core\User\Entity\Grade;
use SDIS62\Core\User\Entity\Profile;
use SDIS62\Core\User\Exception\InvalidGradeException;
use SDIS62\Core\User\Exception\InvalidProfileException;
use SDIS62\Core\User\Repository\UserRepositoryInterface;
use SDIS62\Core\User\Repository\GradeRepositoryInterface;
use SDIS62\Core\User\Repository\ProfileRepositoryInterface;

class UserService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\User\Repository\UserRepositoryInterface    $user_repository
     * @param SDIS62\Core\User\Repository\ProfileRepositoryInterface $profile_repository
     * @param SDIS62\Core\User\Repository\GradeRepositoryInterface   $grade_repository
     */
    public function __construct(UserRepositoryInterface $user_repository,
                                ProfileRepositoryInterface $profile_repository,
                                GradeRepositoryInterface $grade_repository
    ) {
        $this->user_repository = $user_repository;
        $this->profile_repository = $profile_repository;
        $this->grade_repository = $grade_repository;
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
     *     'picture_url' => 'http://www.sdis62.fr/avatar.jpg',
     *     'profiles' => array(
     *          array('type' => 'maire', 'code_insee' => '62000'),
     *          array('type' => 'sapeur_pompier', 'grade' => array('id' => 1), 'poste' => 'Sapeur', 'pro' => true),
     *          array('type' => 'personnel_administratif', 'grade' => array('id' => 2), 'poste' => 'Chef de service'),
     *          array('type' => 'personnel_technique', 'grade' => array('id' => 3), 'poste' => 'Developpeur')
     *     )
     * );
     * </code>
     *
     * $data doit contenir au moins les index suivant : gender, last_name, first_name, email pour une création
     * $data peut contenir les index suivants : password
     * Pour mettre à jour une entité, le tableau $data doit contenir un index "id" comportant l'id de
     * l'entité à mettre à jour.
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

        if (!empty($data['profiles']) && is_array($data['profiles'])) {
            $profiles = array();
            foreach ($data['profiles'] as $profile) {
                $profiles[] = $this->loadProfile($profile);
            }
            $user->setProfiles($profiles);
        }

        $this->user_repository->save($user);

        return $user;
    }

    /**
     * Fonction d'aide à la sauvegarde d'un profil sur un utilisateur
     *
     * <code>
     * $array = array(
     *     'type' => 'sapeur_pompier',
     *     'grade' => array('id' => 1),
     *     'poste' => 'Sapeur',
     *     'pro' => true
     * );
     * </code>
     *
     * @param  array                           $data
     * @return SDIS62\Core\User\Entity\Profile
     */
    private function loadProfile($data)
    {
        if (empty($data['id'])) {
            switch ($data['type']) {
                case 'sapeur_pompier' :
                    $profile = new Profile\Sdis\SapeurPompierSdisProfile($this->loadGrade($data['grade']), $data['poste'], empty($data['pro']) ? false : $data['pro']);
                    break;
                case 'personnel_administratif' :
                    $profile = new Profile\Sdis\PersonnelAdministratifSdisProfile($this->loadGrade($data['grade']), $data['poste']);
                    break;
                case 'personnel_technique' :
                    $profile = new Profile\Sdis\PersonnelTechniqueSdisProfile($this->loadGrade($data['grade']), $data['poste']);
                    break;
                case 'maire' :
                    $profile = new Profile\MaireProfile($data['code_insee']);
                    break;
                default:
                    throw new InvalidProfileException();
            }
        } else {
            $profile = $this->profile_repository->find($data['id']);

            if (!empty($data['code_insee'])) {
                $profile->setCodeInsee($data['code_insee']);
            }

            if (!empty($data['poste'])) {
                $profile->setPoste($data['poste']);
            }

            if (!empty($data['pro'])) {
                $profile->setPro($data['pro']);
            }

            if (!empty($data['grade'])) {
                $profile->setGrade($this->loadGrade($data['grade']));
            }
        }

        return $profile;
    }

    /**
     * Fonction d'aide à la sauvegarde d'un grade sur un profil
     *
     * <code>
     * $array = array(
     *     'type' => 'administratif',
     *     'label' => 'Lieutenant',
     *     'value' => 10
     * );
     * </code>
     *
     * @param  array                         $data
     * @return SDIS62\Core\User\Entity\Grade
     */
    private function loadGrade($data)
    {
        if (empty($data['id'])) {
            switch ($data['type']) {
                case 'sapeur_pompier' :
                    $grade = new Grade\SapeurPompierGrade($data['label'], $data['value']);
                    break;
                case 'administratif' :
                    $grade = new Grade\AdministratifGrade($data['label'], $data['value']);
                    break;
                case 'technique' :
                    $grade = new Grade\TechniqueGrade($data['label'], $data['value']);
                    break;
                default:
                    throw new InvalidGradeException();
            }
        } else {
            $grade = $this->grade_repository->find($data['id']);

            if (!empty($data['label'])) {
                $grade->setLabel($data['label']);
            }

            if (!empty($data['value'])) {
                $grade->setValue($data['value']);
            }
        }

        return $grade;
    }

    /**
     * Suppression d'un utilisateur
     *
     * @param int $id ID de l'utilisateur à supprimer
     */
    public function delete($id)
    {
        $user = $this->find($id);
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
