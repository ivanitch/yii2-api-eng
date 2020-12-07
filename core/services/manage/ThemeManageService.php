<?php

namespace core\services\manage;

use core\entities\Theme\Theme;
use core\forms\manage\Theme\ThemeForm;
use core\repositories\ThemeRepository;

class ThemeManageService
{
    private $repository;

    public function __construct(ThemeRepository $themeRepository)
    {
        $this->repository = $themeRepository;
    }

    public function create(ThemeForm $form): Theme
    {
        $level = Theme::create(
            $form->category_id,
            $form->level_id,
            $form->name,
            $form->image
        );
        $this->repository->save($level);
        return $level;
    }

    public function edit($id, ThemeForm $form): void
    {
        $level = $this->repository->get($id);
        $level->edit(
            $form->category_id,
            $form->level_id,
            $form->name,
            $form->image
        );
        $this->repository->save($level);
    }

    public function remove($id): void
    {
        $level = $this->repository->get($id);
        $this->repository->remove($level);
    }
}