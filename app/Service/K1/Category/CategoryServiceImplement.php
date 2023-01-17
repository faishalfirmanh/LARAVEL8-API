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

   public function updateCategoryService($data)
   {
        $validator = Validator::make($data->all(),[
            'id_category'=> 'required|numeric',
            'name_category' => ['required',new Rules_category_name],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $search = $this->categoryRepositry->getCategoryById($data->id_category);
            if ($search != NULL) {
                $save = $this->categoryRepositry->updateCategory($data->id_category,$data->name_category);
                return  response()->json([
                        "status"=>"update success",
                        "data"=>$save
                    ],200);
            }else{
                return response()->json([
                        "status"=>"update failed",
                        "data"=>'id not found',
                        'id'=>$data->id_category
                    ],404);
            }
        }
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

   public function deleteCategoryService($data)
   {
        $validator = Validator::make($data->all(),[
            'id_category'=> 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $result_find = $this->categoryRepositry->getCategoryById($data->id_category);
            if ($result_find != NULL) {
                if (cekCategoryRelationProdByIdCategory($data->id_category) != null) {
                    return response()->json([
                        'status'=>'category is have realtions',
                        'data' => 'deleted failed',
                        'id'=>$data->id_category
                    ],404);
                }else{
                    $this->categoryRepositry->deleteCategory($data->id_category);
                    return response()->json([
                        'status'=>'deleted success',
                        'id' => $data->id_category
                    ],200);
                }
            }else{
                return response()->json([
                    'status'=>'category not found',
                    'data' => 'deleted failed',
                    'id'=>$data->id_category
                ],404);
            }
        }
   }

   public function getCategoryIdServiceRequest($data)
   {
        $validator = Validator::make($data->all(),[
            'id_category'=> 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $data = $this->categoryRepositry->getCategoryById($data->id_category);
            if ($data != NULL) {
                return response()->json([
                    'status'=>'success',
                    'data' => $data
                ],200);
            }else{
                return response()->json([
                    'status'=>'category not found',
                    'data' => 'empty'
                ],404);
            }
           
        }
   }
   public function getCategoryNameServiceRequest($data)
   {

   }
}