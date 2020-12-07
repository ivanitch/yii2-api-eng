<?php

namespace core\storage;

interface ResizeInterface
{
    public static function resize($file): void;
}