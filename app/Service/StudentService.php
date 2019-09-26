<?php


namespace App\Service;


use App\Model\Student;

class StudentService
{
    /** @var Student $student */
    private $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function studentList()
    {
        return $this->student->where('id', '>', '0')->get();
    }
}
