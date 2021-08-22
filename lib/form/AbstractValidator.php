<?php
namespace Lib\form;

abstract class AbstractValidator
{
    protected $message;
    protected $field;
    protected $model;

    public function __construct($field, $model){
        $this->field = $field;
        $this->model = $model;
    }

    abstract public function validate();

    public function getMessage(){
        return $this->message;
    }
}