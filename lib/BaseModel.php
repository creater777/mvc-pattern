<?php
namespace Lib;

use RedBeanPHP\SimpleModel;

class BaseModel extends SimpleModel
{
    protected $table;
    private $childClass;

    /**
     * BaseModel constructor.
     * @param null $bean
     * @throws \Exception
     */
    public function __construct($bean = null) {
        $this->childClass = get_called_class();
        $this->table = self::getTable();
        $this->loadBean($bean === null ?
            App::getDBInstance()::dispense(self::getTable()) :
            $bean
        );
    }

    public static function getTable(){
        $child = get_called_class();
        return mb_strtolower(substr($child, strrpos($child, '\\') + 1));
    }

    /**
     * @param $from
     * @param $to
     * @return array
     * @throws \Exception
     */
    public static function getFromTo($from, $to){
        $childClass = get_called_class();
        $list = App::getDBInstance()::find(self::getTable(), "LIMIT $from, $to");
        return array_map(function($row) use ($childClass){
            $child = new $childClass();
            $child->loadBean($row);
            return $child;
        }, $list);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public static function find($id){
        $childClass = get_called_class();
        $row = App::getDBInstance()::findOne(self::getTable(), 'id=:id', ["id" => $id]);
        $child = new $childClass();
        $child->loadBean($row);
        return $child;
    }

    /**
     * @return int|string
     * @throws \RedBeanPHP\RedException\SQL
     * @throws \Exception
     */
    public function store(){
        return App::getDBInstance()::store($this->bean);
    }

    public function __get($name) {
        if (method_exists($this, 'get'.ucfirst($name))){
            return htmlspecialchars($this->{'get'.ucfirst($name)}());
        } else {
            return htmlspecialchars(parent::__get($name));
        }
    }
}