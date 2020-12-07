<?php

namespace core\forms\manage\Level;

use core\entities\Level\Level;
use core\forms\CompositeForm;
use core\validators\CodeValidator;

class LevelForm extends CompositeForm
{
    public $name;
    public $code;

    private $level;

    public function __construct(Level $level = null, $config = [])
    {
        if ($level) {
            $this->name = $level->name;
            $this->code = $level->code;
            $this->level = $level;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'code'], 'required'],
            [['name', 'code'], 'string', 'max' => 100],
            [['name', 'code'], 'unique', 'targetClass' => Level::class, 'filter' => $this->level ? ['<>', 'id', $this->level->id] : null],
            ['code', CodeValidator::class]
        ];
    }

    protected function internalForms(): array
    {
        return [false];
    }
}