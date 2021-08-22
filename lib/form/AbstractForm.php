<?php
namespace Lib\form;

abstract class AbstractForm
{
    private $errors = array();

    abstract public function getRules();

    public function validate(){
        $this->errors = array();
        foreach ($this->getRules() as $field => $validatorClass){
            $valivator = new $validatorClass($field, $this);
            try{
                $valivator->validate();
            } catch (Exception $e){
                array_push($this->errors, $e->getMessage());
            }
        }
        return empty($this->errors);
    }

    public function save(){
        if ($this->validate() !== true){
            return false;
        }
    }
}