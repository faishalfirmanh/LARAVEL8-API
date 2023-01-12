<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use App\Http\Requests\K1_Category_Request;
use App\Repository\K1\Category\CategoryRepository;
use App\Service\K1\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    //
    private $categoryService;
    //kalau dipindah ke repository saja tinggal di ganti diconstruct dan nama functionnya
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        // $result = $this->category->getAllCategory();
        // return response()->json([
        //     "status"=>"ok",
        //     "data"=>$result
        // ],200);
    }

    public function getCategoryIdCon($id)
    {
        $result = $this->categoryService->getCategoryByIdService($id);
        return response()->json([
            "status"=>"ok",
            "data"=>$result
        ],200);  
    }
    public function getCategoryByNameCon($name){
        $result = $this->categoryService->getCategoryByNameService($name);
        return $result;
    }

    public function getCategory_IdCon(K1_Category_Request $request)
    {

    }

    public function getCategory_NameCon(Request $request)
    {
        
    }

    public function postCategory_Con(Request $request)
    {
        $result = $this->categoryService->postCategoryService($request);
        return $result;
    }
    public function updateCategory_Con(Request $request)
    {

    }
}
