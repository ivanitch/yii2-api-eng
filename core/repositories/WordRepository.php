<?php

namespace core\repositories;

use core\entities\Word\Word;

class WordRepository
{
    public function get($id): Word
    {
        if (!$word = Word::findOne($id)) {
            throw new NotFoundException('Word is not found.');
        }
        return $word;
    }

    public function save(Word $word): void
    {
        if (!$word->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Word $word): void
    {
        if (!$word->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}