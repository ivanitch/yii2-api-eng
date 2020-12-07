<?php

namespace core\validators;

use yii\validators\RegularExpressionValidator;

class CodeValidator  extends RegularExpressionValidator
{
    public $pattern = '#^[A-Z0-9_-]*$#s';
    public $message = 'Only [A-Z0-9_-] symbols are allowed.';
}