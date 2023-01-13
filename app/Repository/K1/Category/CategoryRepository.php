<?php
namespace App\Repository\K1\Category;

interface CategoryRepository{
    public function getAllCategory();
    public function getCategoryById($id);
    public function getCategoryByName($name);
    public function postCategory($name);
    public function updateCategory($id_category, $name);
    public function deleteCategory($id); 
}