<?php

namespace App\Service\K1\Category;


interface CategoryService{
    public function getCategoryByIdService($id);
    public function getCategoryByNameService($name);

    public function postCategoryService($data);
    public function updateCategoryService($data);
    public function deleteCategoryService($data);

    public function getCategoryIdServiceRequest($data);
    public function getCategoryNameServiceRequest($data);
}