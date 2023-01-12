<?php

namespace App\Service\K1\Category;

use App\Models\k1\K1_Category;
use Illuminate\Support\Facades\Log;
use App\Repository\K1\Category\CategoryRepository;
use App\Rules\K1\Rules_category_name;
use App\Rules\K1\Rules_cek_special_character;
use Illuminate\Support\Facades\Validator;

class CategoryServiceImplement implements CategoryService{
    
    protected $categoryRepositry;
    public function __construct(CategoryRepository $categoryRepositry)
    {
        $this->categoryRepositry = $categoryRepositry;
    }

   public function getCategoryByNameService($name)
   {
    
        $data = $this->categoryRepositry->getCategoryByName($name);
        if (count($data)>0) {
            return  response()->json([
                        "status"=>"ok",
                        "data"=>$data
                    ],200);
        }else{
            return  response()->json([
                "status"=>"no",
                "data"=>'not found'
            ],404);
        }
         
   }
   public function getCategoryByIdService($id)
   {
      return $this->categoryRepositry->getCategoryById($id);
   } 

   public function postCategoryService($data){
        $validator = Validator::make($data->all(), [
            'name_category' => ['required',new Rules_category_name],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $save = $this->categoryRepositry->postCategory($data->name_category);
            return  response()->json([
                "status"=>"ok",
                "data"=>$save
            ],200);
        }
   }
}