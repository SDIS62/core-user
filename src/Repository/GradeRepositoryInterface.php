<?php

namespace SDIS62\Core\User\Repository;

use SDIS62\Core\User\Entity\Grade;

interface GradeRepositoryInterface
{
    /**
     * Retourne un ensemble de grades
     *
     * @return SDIS62\Core\User\Entity\Grade[]
     */
    public function getAll();

    /**
     * Retourne un grade correspondant à l'id spécifié
     *
     * @param  int                           $id_grade
     * @return SDIS62\Core\User\Entity\Grade
     */
    public function find($id_grade);

    /**
     * Suppression d'un grade
     *
     * @param  SDIS62\Core\User\Entity\Grade
     */
    public function delete(Grade & $grade);
}
