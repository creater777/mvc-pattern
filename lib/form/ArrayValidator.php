<?php
namespace Lib\form;

class ArrayValidator extends AbstractValidator
{

    public function validate()
    {
        return is_array($this->model->{$this->field});
    }
}