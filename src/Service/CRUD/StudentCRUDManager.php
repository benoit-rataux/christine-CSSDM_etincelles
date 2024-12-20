<?php

namespace App\Service\CRUD;

use App\Entity\Student;
use App\Repository\StudentRepository;

/**
 * @template-extends AbstractCRUDManager<Student>
 */
class StudentCRUDManager extends AbstractCRUDManager {
    
    public function __construct(
        StudentRepository $repository,
    ) {
        parent::__construct($repository);
    }
}