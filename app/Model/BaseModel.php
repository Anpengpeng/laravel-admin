<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected static $modelArr;

    /**
     * @param $modelName
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getInstance($modelName)
    {
        if (!isset(self::$modelArr[$modelName])) {
            $class = new $modelName;
            self::$modelArr[$modelName] = $class;
        }

        return self::$modelArr[$modelName];
    }
}
