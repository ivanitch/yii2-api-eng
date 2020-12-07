<?php

namespace core\services\manage;

use core\entities\Level\Level;
use core\forms\manage\Level\LevelForm;
use core\repositories\LevelRepository;

class LevelManageService
{
    private $repository;

    public function __construct(LevelRepository $levelRepository)
    {
        $this->repository = $levelRepository;
    }

    public function create(LevelForm $form): Level
    {
        $level = Level::create($form->name, strtoupper($form->code));
        $this->repository->save($level);
        return $level;
    }

    public function edit($id, LevelForm $form): void
    {
        $level = $this->repository->get($id);
        $level->edit($form->name, strtoupper($form->code));
        $this->repository->save($level);
    }

    public function remove($id): void
    {
        $level = $this->repository->get($id);
        $this->repository->remove($level);
    }
}