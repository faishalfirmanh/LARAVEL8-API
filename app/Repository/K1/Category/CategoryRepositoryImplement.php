<?php

namespace App\Repository\K1\Category;
use App\Models\k1\K1_Category;


class CategoryRepositoryImplement implements CategoryRepository{

    private $model;
    public function __construct(K1_Category $model)
    {
        $this->model = $model;
    }

    public function getAllCategory()
    {
        return $this->model->all();
    }
    

    public function getCategoryById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getCategoryByName($name)
    {
        return $this->model->where('name_category','LIKE','%'.$name.'%')->get(); 
    }
    public function postCategory($name){
         $model_save = $this->model;
         $model_save->name_category = $name;
         $model_save->save();
         return $model_save->fresh();
    }

    

} 