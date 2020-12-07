<?php

namespace core\forms\manage\Word;

use core\entities\Word\Word;
use core\forms\CompositeForm;

/**
 * @property ImageForm $image;
 * @property SoundForm $sound;
 */
class WordForm extends CompositeForm
{
    public $name;
    public $translation;
    public $transcription;
    public $example;

    private $word;

    public function __construct(Word $word = null, $config = [])
    {
        if ($word) {
            $this->name = $word->name;
            $this->translation = $word->translation;
            $this->transcription = $word->transcription;
            $this->example = $word->example;
            $this->sound = new SoundForm();
            $this->image = new ImageForm();
            $this->word = $word;
        } else {
            $this->sound = new SoundForm();
            $this->image = new ImageForm();
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'translation', 'transcription'], 'required'],
            [['example'], 'string'],
            [['name', 'translation', 'transcription'], 'string', 'max' => 255]
        ];
    }

    protected function internalForms(): array
    {
        return ['image', 'sound'];
    }
}