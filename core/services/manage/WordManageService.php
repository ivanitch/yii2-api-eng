<?php

namespace core\services\manage;

use core\entities\Word\Word;
use core\forms\manage\Word\WordForm;
use core\repositories\WordRepository;

class WordManageService
{
    private $repository;

    public function __construct(WordRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(WordForm $form): Word
    {
        $word = Word::create(
            $form->name,
            $form->translation,
            $form->transcription,
            $form->example,
            $form->sound,
            $form->image
        );
        $this->repository->save($word);
        return $word;
    }

    public function edit($id, WordForm $form): void
    {
        $word = $this->repository->get($id);
        $word->edit(
            $form->name,
            $form->translation,
            $form->transcription,
            $form->example,
            ($form->sound !== '') ? $form->sound : $word->sound,
            ($form->image !== '') ? $form->image : $word->image
        );
        $this->repository->save($word);
    }

    public function remove($id): void
    {
        $word = $this->repository->get($id);
        $this->repository->remove($word);
    }

    public function save(Word $word)
    {
        $this->repository->save($word);
    }
}