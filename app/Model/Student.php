<?php


namespace App\Model;


class Student extends BaseModel
{
    protected $table = 'student';

    public function __construct()
    {
        parent::__construct();
        logger('Student');
    }

}
