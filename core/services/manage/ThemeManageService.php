<?php

namespace core\services\manage;

use core\entities\Theme\Theme;
use core\forms\manage\Theme\ThemeForm;
use core\forms\manage\Theme\WordsForm;
use core\repositories\ThemeRepository;
use core\repositories\WordRepository;
use core\services\TransactionManager;

class ThemeManageService
{
    private $repository;
    private $words;
    private $transaction;

    public function __construct(
        ThemeRepository $themeRepository,
        WordRepository $wordRepository,
        TransactionManager $transaction
    )
    {
        $this->repository = $themeRepository;
        $this->words = $wordRepository;
        $this->transaction = $transaction;
    }

    public function create(ThemeForm $form): Theme
    {
        $theme = Theme::create(
            $form->category_id,
            $form->level_id,
            $form->name,
            $form->image
        );

        $this->repository->save($theme);
        return $theme;
    }

    public function edit($id, ThemeForm $form): void
    {
        $theme = $this->repository->get($id);
        $theme->edit(
            $form->category_id,
            $form->level_id,
            $form->name,
            $form->image
        );
        $this->repository->save($theme);
    }

    public function remove($id): void
    {
        $theme = $this->repository->get($id);
        $this->repository->remove($theme);
    }


    public function addWords(Theme $theme, WordsForm $form)
    {
        $theme->revokeWords();
        $this->repository->save($theme);
        $this->transaction->wrap(function () use ($theme, $form) {

            foreach ($form->existing as $wordId) {
                $word = $this->words->get($wordId);
                $theme->assignWord($word->id);
            }
            $this->repository->save($theme);
        });
    }


}