<?php


namespace App\Http\Controllers\Student;


use App\Http\Controllers\AuthController;
use App\Model\Student;
use App\Service\StudentService;
use Illuminate\Http\Request;

class StudentController extends AuthController
{
    private $studentService;

    public function __construct(Request $request, StudentService $studentService)
    {
        parent::__construct($request);
        $this->studentService = $studentService;
    }

    /**
     * 学生列表
     * @return mixed
     */
    public function studentList()
    {
        $ret = Student::getInstance(Student::class);
        return $this->studentService->studentList();
    }

}
