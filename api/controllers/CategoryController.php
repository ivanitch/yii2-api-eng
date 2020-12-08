<?php

namespace api\controllers;

use api\core\entities\Category;

class CategoryController extends BaseRestController
{
    /* @var $modelClass Category */
    public $modelClass = Category::class;
}
