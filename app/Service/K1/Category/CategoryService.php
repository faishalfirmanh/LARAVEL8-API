<?php

namespace App\Service\K1\Category;


interface CategoryService{
    public function getCategoryByIdService($id);
    public function getCategoryByNameService($name);

    public function postCategoryService($data);
}