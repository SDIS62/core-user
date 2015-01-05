<?php

namespace SDIS62\Core\User\Service;

use SDIS62\Core\User\Entity\Grade;
use SDIS62\Core\User\Repository\GradeRepositoryInterface;

class GradeService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\User\Repository\GradeRepositoryInterface   $grade_repository
     */
    public function __construct(GradeRepositoryInterface $grade_repository)
    {
        $this->grade_repository = $grade_repository;
    }

    /**
    * Retourne un ensemble de grades
    *
    * @return SDIS62\Core\User\Entity\Grade[]
    */
    public function getAll()
    {
        return $this->grade_repository->getAll();
    }

    /**
    * Retourne un grade correspondant à l'id spécifié
    *
    * @param  int                           $id_grade
    * @return SDIS62\Core\User\Entity\Grade
    */
    public function find($id_grade)
    {
        return $this->grade_repository->find($id_grade);
    }

    /**
    * Suppression d'un grade
    *
    * @param int $id ID du grade à supprimer
    */
    public function delete($id)
    {
        $grade = $this->find($id);
        $this->grade_repository->delete($grade);
    }
}
