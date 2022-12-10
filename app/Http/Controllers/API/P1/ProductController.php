<?php

namespace App\Http\Controllers\API\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P1\Product;
use Image;
use File;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Product::query()->get();
        $var = array();
        foreach ($data as $key) {
           array_push($var,$key);
        }
        return response()->json([
            'data' => $var,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $name = $request->name;
        $img = $request->file('image');
        $price = $request->price;
        if ($img != NULL) {
            $width_img = Image::make($img->getRealPath())->width();
            $height_img =  Image::make($img->getRealPath())->height();
            $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$name.'.jpg';
            $image_resize = Image::make($img->getRealPath());  
            $image_resize->resize(200, 200);
            //$image_resize->crop(200, 200);
            //$img->move(public_path('storage/image_product'), $name_image); //upload image laravel
            $image_resize->save(public_path('image_product/' .$name_image),40); //upload image image intervention
            $product = new Product();
            $product->name_product = $name;
            $product->price = $price;
            $product->picture = $name_image;
            if ($product->save()) {
                return response()->json([
                    'message' => 'success create',
                ],200);  
            }
        }else{
            return response()->json([
                'message' => 'failed create',
                'validation'=>[
                    'error'=> 'please upload image'
                ]
            ],401);   
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json([
            'message' => 'delete successfully',
            'validation'=>[
                'msg1'=> 'image already deleted'
            ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateProduct(Request $request)
    {
        $id = $request->id;
        var_dump($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct(Request $request)
    {
        $search = Product::query()->where('id',$request->id)->first();
        if ($search != NULL) {
            $img_name = $search->picture;
            $cek_file = File::exists(public_path('image_product/'.$img_name));
            if ($cek_file) {
                unlink(public_path('image_product')."/".$img_name);
                DB::table('p1_product')->where('id', $request->id)->delete();
                return response()->json([
                    'message' => 'delete successfully',
                    'validation'=>[
                        'msg1'=> 'image already deleted'
                    ]
                ],200);
                
            }else{
                DB::table('p1_product')->where('id', $request->id)->delete();
                return response()->json([
                    'message' => 'delete successfully',
                    'validation'=>[
                        'msg1'=> 'image not found'
                    ]
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'delete failed',
                'validation'=>[
                    'error'=> 'data not found'
                ]
            ],401);
        }
    }
    public function destroy(Request $request, $id)
    {
        //
        $idInput = $request->id;
        $search = Product::query()->where('id',$id)->first();
        var_dump($search);
        var_dump($idInput);
    }
}
