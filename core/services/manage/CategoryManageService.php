<?php

namespace core\services\manage;

use core\entities\Category\Category;
use core\forms\manage\Category\CategoryForm;
use core\repositories\CategoryRepository;

class CategoryManageService
{
    private $repository;

    public function __construct(CategoryRepository $categories)
    {
        $this->repository = $categories;
    }

    public function create(CategoryForm $form): Category
    {
        $category = Category::create($form->name, $form->icon);
        $this->repository->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form): void
    {
        $category = $this->repository->get($id);
        $category->edit($form->name, $form->icon);
        $this->repository->save($category);
    }

    public function remove($id): void
    {
        $category = $this->repository->get($id);
        $this->repository->remove($category);
    }
}