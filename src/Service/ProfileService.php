<?php

namespace SDIS62\Core\User\Service;

use SDIS62\Core\User\Entity\Profile;
use SDIS62\Core\User\Exception\InvalidProfileException;
use SDIS62\Core\User\Repository\UserRepositoryInterface;
use SDIS62\Core\User\Repository\ProfileRepositoryInterface;

class ProfileService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\User\Repository\ProfileRepositoryInterface $profile_repository
     * @param SDIS62\Core\User\Repository\UserRepositoryInterface    $user_repository
     */
    public function __construct(ProfileRepositoryInterface $profile_repository,
                                UserRepositoryInterface $user_repository
    ) {
        $this->profile_repository = $profile_repository;
        $this->user_repository = $user_repository;
    }

    /**
     * Retourne un grade correspondant à l'id spécifié
     *
     * @param  int                             $id_profile
     * @return SDIS62\Core\User\Entity\Profile
     */
    public function find($id_profile)
    {
        return $this->profile_repository->find($id_profile);
    }

    /**
     * Retourne les profils d'un utilisateur
     *
     * @param  int                               $id_user
     * @return SDIS62\Core\User\Entity\Profile[]
     */
    public function findAllByUser($id_user)
    {
        return $this->profile_repository->findAllByUser($id_user);
    }

    /**
     * Sauvegarde d'un profil
     *
     * <code>
     * $array = array(
     *     'type' => 'sapeur_pompier|personnel_administratif|personnel_technique|maire',
     *     'grade' => 'Nom du grade (pour sapeur_pompier|personnel_administratif|personnel_technique)',
     *     'poste' => 'Nom du poste (pour sapeur_pompier|personnel_administratif|personnel_technique)',
     *     'pro' => 'true (pour sapeur_pompier)',
     *     'code_insee' => '62001 (pour maire)'
     * );
     * </code>
     *
     * @param  array                           $data
     * @return SDIS62\Core\User\Entity\Profile
     */
    public function save(array $data)
    {
        if (empty($data['id'])) {
            switch ($data['type']) {
                case 'sapeur_pompier' :
                    $profile = new Profile\Sdis\SapeurPompierSdisProfile($this->user_repository->find($data['user']), $data['grade'], $data['poste'], empty($data['pro']) ? false : (bool) $data['pro']);
                    break;
                case 'personnel_administratif' :
                    $profile = new Profile\Sdis\PersonnelAdministratifSdisProfile($this->user_repository->find($data['user']), $data['grade'], $data['poste']);
                    break;
                case 'personnel_technique' :
                    $profile = new Profile\Sdis\PersonnelTechniqueSdisProfile($this->user_repository->find($data['user']), $data['grade'], $data['poste']);
                    break;
                case 'maire' :
                    $profile = new Profile\MaireProfile($this->user_repository->find($data['user']), $data['code_insee']);
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
                $profile->promote($data['grade']);
            }
        }

        $this->profile_repository->save($profile);

        return $profile;
    }

    /**
     * Suppression d'un profil
     *
     * @param int $id_profile
     */
    public function delete($id_profile)
    {
        $profile = $this->find($id_profile);
        $this->profile_repository->delete($profile);
    }
}
