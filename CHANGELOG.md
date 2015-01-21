# Changelog

All Notable changes to `core-user` will be documented in this file

## 0.2.0 - 2015-01-21

### Added
- Ajout SDIS62\Core\User\Service\ProfileService ;
- Ajout d'une méthode findByUser dans le repository Profile.

### Fixed
- Correction des namespaces dans tests/ ;
- Ajout des ```use Datetime``` manquants ;
- Correction dans les commentaires du nom du paramètre id dans find::ProfileRepositoryInterface ;
- Ajout de tests permettant de vérifier les ArrayCollections ;
- [BC] Simplification de la gestion des grades et d'ajout de profils à un utilisateur ;
- Modification de la visibilité des attributs (passer de private à protected).

### Removed
- Suppression de SDIS62\Core\User\Entity\Grade (et les fils) ;
- Suppression de SDIS62\Core\User\Repository\GradeRepositoryInterface ;
- Suppression de SDIS62\Core\User\Service\GradeService ;
- Suppression de SDIS62\Core\User\Exception\InvalidGradeException.

## 0.1.0 - 2015-01-05

Initial commit
