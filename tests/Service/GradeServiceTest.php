<?php

namespace SDIS62\Core\User\Test\Service;

use Mockery;
use SDIS62\Core\User as Core;
use PHPUnit_Framework_TestCase;

class GradeServiceTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $grade_sp = new Core\Entity\Grade\SapeurPompierGrade('Lieutenant', 10);
        $grade_administratif = new Core\Entity\Grade\AdministratifGrade('Redacteur', 10);
        $grade_technique = new Core\Entity\Grade\TechniqueGrade('Ingenieur', 10);

        $grade_sp->setId(1);
        $grade_administratif->setId(2);
        $grade_technique->setId(3);

        $repository_grade_mock = Mockery::mock('SDIS62\Core\User\Repository\GradeRepositoryInterface');
        $repository_grade_mock->shouldReceive('getAll')->andReturn(array($grade_sp, $grade_administratif, $grade_technique));
        $repository_grade_mock->shouldReceive('find')->with(1)->andReturn($grade_sp);
        $repository_grade_mock->shouldReceive('find')->with(2)->andReturn($grade_administratif);
        $repository_grade_mock->shouldReceive('find')->with(3)->andReturn($grade_technique);
        $repository_grade_mock->shouldReceive('save');
        $repository_grade_mock->shouldReceive('delete');

        self::$object = new Core\Service\GradeService($repository_grade_mock);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\User\Service\GradeService', self::$object);
    }

    public function test_if_it_find()
    {
        $this->assertEquals(2, self::$object->find(2)->getId());
    }

    public function test_if_it_get_all()
    {
        $this->assertCount(3, self::$object->getAll());
    }

    public function test_if_it_delete()
    {
        self::$object->delete(2);
    }
}
