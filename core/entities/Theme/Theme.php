<?php

namespace core\entities\Theme;

use core\entities\Category\Category;
use core\entities\Level\Level;
use core\entities\Word\Word;
use core\storage\Theme\ImageStorage;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
/**
 * This is the model class for table "{{%theme}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $level_id
 * @property string $name
 * @property string $image
 *
 * @property Category $category
 * @property Level $level
 *
 * @property WordAssignment[] $wordAssignments
 * @property Word[] $words
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%theme}}';
    }

    public static function create($category_id, $level_id, $name, $image): self
    {
        $theme = new static();
        $theme->category_id = $category_id;
        $theme->level_id = $level_id;
        $theme->name = $name;
        $theme->image = $image;
        return $theme;
    }

    public function edit($category_id, $level_id, $name, $image): void
    {
        $this->category_id = $category_id;
        $this->level_id = $level_id;
        $this->name = $name;
        $this->image = ($image !== '') ? $image : $this->image;
    }

    public function getImagePath()
    {
        if ($this->image) return ImageStorage::getHostInfo() . $this->image;
        return 'https://via.placeholder.com/100x100';
    }

    public function beforeDelete()
    {
        ImageStorage::deleteImage($this);
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLevel(): ActiveQuery
    {
        return $this->hasOne(Level::class, ['id' => 'level_id']);
    }

    //====== Words ======
    public function assignWord($id): void
    {
        $assignments = $this->wordAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForWord($id)) {
                return;
            }
        }
        $assignments[] = WordAssignment::create($id);
        $this->wordAssignments = $assignments;
    }

    public function revokeWord($id): void
    {
        $assignments = $this->wordAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForWord($id)) {
                unset($assignments[$i]);
                $this->wordAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeWords(): void
    {
        $this->wordAssignments = [];
    }

    public function getWordAssignments(): ActiveQuery
    {
        return $this->hasMany(WordAssignment::class, ['theme_id' => 'id']);
    }

    public function getWords(): ActiveQuery
    {
        return $this->hasMany(Word::class, ['id' => 'word_id'])->via('wordAssignments');
    }

    public function getWordsCount(): int
    {
        return $this->getWords()->count();
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['wordAssignments']
            ]
        ];
    }
}
