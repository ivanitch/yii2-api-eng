<?php

namespace core\entities\Theme;

use yii\db\ActiveRecord;
/**
 * @property integer $theme_id;
 * @property integer $word_id;
 */
class WordAssignment extends ActiveRecord
{
    public static function create($wordId): self
    {
        $assignment = new static();
        $assignment->word_id = $wordId;
        return $assignment;
    }

    public function isForWord($id): bool
    {
        return $this->word_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%word_assignments}}';
    }
}