<?php

namespace core\forms\manage\Theme;

use core\entities\Theme\Theme;
use core\entities\Word\Word;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class WordsForm extends Model
{
    public $existing = [];

    public function __construct(Theme $model = null, $config = [])
    {
        if ($model) {
            $this->existing = ArrayHelper::getColumn($model->wordAssignments, 'word_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['existing', 'default', 'value' => []],
        ];
    }

    public function list(): array
    {
        return ArrayHelper::map(Word::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function attributeLabels()
    {
        return ['existing' => 'Words'];
    }
}