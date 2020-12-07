<?php

namespace core\entities\Word;

use core\storage\Word\ImageStorage;
use core\storage\Word\SoundStorage;
/**
 * This is the model class for table "{{%word}}".
 *
 * @property int $id
 * @property string $name
 * @property string $translation
 * @property string $transcription
 * @property string|null $example
 * @property string $sound
 * @property string $image
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%word}}';
    }

    public static function create(
        string $name,
        string $translation,
        string $transcription,
        string $example,
        string $sound,
        string $image
    ): self
    {
        $word = new static();
        $word->name = $name;
        $word->translation = $translation;
        $word->transcription = $transcription;
        $word->example = $example;
        $word->sound = $sound;
        $word->image = $image;
        return $word;
    }

    public function edit(
        string $name,
        string $translation,
        string $transcription,
        string $example,
        string $sound,
        string $image
    ): void
    {
        $this->name = $name;
        $this->translation = $translation;
        $this->transcription = $transcription;
        $this->example = $example;
        $this->sound = $sound;
        $this->image = $image;
    }

    public function getImagePath(): string
    {
        if ($this->image) return ImageStorage::getHostInfo() . $this->image;
        return 'https://via.placeholder.com/300x200';
    }

    public function getSound(): string
    {
        if ($this->sound) {
            $sound = SoundStorage::getHostInfo() . $this->sound;
            return '<audio src="' . $sound . '" controls></audio>';
        } else {
            return '<span class="label label-danger">Not loaded</span>';
        }
    }

    /**
     * @return bool
     */
    public function beforeDelete(): bool
    {
        ImageStorage::deleteImage($this);
        SoundStorage::deleteSound($this);
        return parent::beforeDelete();
    }
}
