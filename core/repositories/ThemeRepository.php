<?php

namespace core\repositories;

use core\entities\Theme\Theme;

class ThemeRepository
{
    public function get($id): Theme
    {
        if (!$theme = Theme::findOne($id)) {
            throw new NotFoundException('Theme is not found.');
        }
        return $theme;
    }

    public function save(Theme $theme): void
    {
        if (!$theme->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Theme $theme): void
    {
        if (!$theme->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}