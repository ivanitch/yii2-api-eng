<?php

namespace core\entities\Level;
/**
 * This is the model class for table "{{%level}}".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%level}}';
    }

    public static function create(string $name, string $code): self
    {
        $level = new static();
        $level->name = $name;
        $level->code = $code;
        return $level;
    }

    public function edit(string $name, string $code): void
    {
        $this->name = $name;
        $this->code = $code;
    }
}
