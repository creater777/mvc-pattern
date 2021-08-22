<?php
namespace Lib\form;

class BooleanValidator extends AbstractValidator
{
    public function validate()
    {
        return is_bool($this->model->{$this->field});
    }
}