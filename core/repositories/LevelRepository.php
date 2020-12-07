<?php

namespace core\repositories;

use core\entities\Level\Level;

class LevelRepository
{
    public function get($id): Level
    {
        if (!$level = Level::findOne($id)) {
            throw new NotFoundException('Level is not found.');
        }
        return $level;
    }

    public function save(Level $level): void
    {
        if (!$level->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Level $level): void
    {
        if (!$level->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}
