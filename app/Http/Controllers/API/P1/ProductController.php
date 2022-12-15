<?php

namespace App\Http\Controllers\API\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P1\Product;
use App\Models\P1\ProductImage;
use Image;
use File;
use Illuminate\Support\Facades\DB;
use Validator;
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

     public function uploadImage2Product($idprod,$p2,$isCreate){
        $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_p2_'.$idprod.'.webp';
        if ($isCreate === true) {
            if($p2 != NULL){
                $image_resize_p2 = Image::make($p2->getRealPath());  
                $image_resize_p2->resize(400, 400);
                $image_resize_p2->save(public_path('img_prod_p2/' .$name_image),40); 
                $path_for_save = public_path('img_prod_p2/'). $name_image;
                $final_path = path_save($path_for_save);
                $img_prod = new ProductImage;
                $img_prod->image_name = $name_image;
                $img_prod->id_product = $idprod;
                $img_prod->path = $final_path;
                $img_prod->save();
            }
        }else{
            if ($p2 != NULL) {
                $data_img_prod = ProductImage::query()->where('id_product',$idprod)->where('image_name','like', '%' . 'p2' . '%')->first();
              
                $image_resize_p2 = Image::make($p2->getRealPath());  
                $image_resize_p2->resize(400,400);
                $path_for_save = public_path('img_prod_p2/'). $name_image;
                $image_resize_p2->save(public_path('img_prod_p2/' .$name_image),40); 
                $final_path = path_save($path_for_save);
                if ($data_img_prod != NULL) {
                    //if file available
                    $name_img =  $data_img_prod->image_name;
                    $cek_file_p2 = File::exists(public_path('img_prod_p2/'.$name_img));
                    if ($cek_file_p2) {
                        unlink(public_path('img_prod_p2')."/".$name_img);
                    }
                    //if file available
                    $data_img_prod->image_name = $name_image;
                    $data_img_prod->path = $final_path;
                    $data_img_prod->save();
                   
                }else{
                    $img_prod = new ProductImage();
                    $img_prod->image_name = $name_image;
                    $img_prod->id_product = $idprod;
                    $img_prod->path = $final_path;
                    $img_prod->save();
                   
                }
            }
        }
        
     }
     
     public function uploadImage3Product($idprod,$p3,$isCreate){
        $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_p3_'.$idprod.'.webp';
        if ($isCreate === true) {
            if($p3 != NULL){
                $image_resize_p3 = Image::make($p3->getRealPath());  
                $image_resize_p3->resize(400, 400);
                $image_resize_p3->save(public_path('img_prod_p3/' .$name_image),40); 
                $path_for_save = public_path('img_prod_p3/'). $name_image;
                $final_path = path_save($path_for_save);
                $img_prod = new ProductImage;
                $img_prod->image_name = $name_image;
                $img_prod->id_product = $idprod;
                $img_prod->path = $final_path;
                $img_prod->save();
            }
        }else{
            if ($p3 != NULL) {
                $data_img_prod = ProductImage::query()->where('id_product',$idprod)->where('image_name','like', '%' . 'p3' . '%')->first();
              
                $image_resize_p3 = Image::make($p3->getRealPath());  
                $image_resize_p3->resize(400,400);
                $path_for_save = public_path('img_prod_p3/'). $name_image;
                $image_resize_p3->save(public_path('img_prod_p3/' .$name_image),40); 
                $final_path = path_save($path_for_save);
                if ($data_img_prod != NULL) {
                    //if file available
                    $name_img =  $data_img_prod->image_name;
                    $cek_file_p3 = File::exists(public_path('img_prod_p3/'.$name_img));
                    if ($cek_file_p3) {
                        unlink(public_path('img_prod_p3')."/".$name_img);
                    }
                    //if file available
                    $data_img_prod->image_name = $name_image;
                    $data_img_prod->path = $final_path;
                    $data_img_prod->save();
                   
                }else{
                    $img_prod = new ProductImage();
                    $img_prod->image_name = $name_image;
                    $img_prod->id_product = $idprod;
                    $img_prod->path = $final_path;
                    $img_prod->save();
                   
                }
            }
        }
        
     }
     public function uploadImage1Product($idprod,$p1,$isCreate){
        $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_p1_'.$idprod.'.webp';
       if ($isCreate === true) {
            if($p1 != NULL) {
                $image_resize_p1 = Image::make($p1->getRealPath());  
                $image_resize_p1->resize(400,400);
                $path_for_save = public_path('img_prod_p1/'). $name_image;
                $image_resize_p1->save(public_path('img_prod_p1/' .$name_image),40); 
                $final_path = path_save($path_for_save);
                $img_prod = new ProductImage();
                $img_prod->image_name = $name_image;
                $img_prod->id_product = $idprod;
                $img_prod->path = $final_path;
                $img_prod->save();
            }
       }else{
            if ($p1 != NULL) {
                $data_img_prod = ProductImage::query()->where('id_product',$idprod)->where('image_name','like', '%' . 'p1' . '%')->first();
              
                $image_resize_p1 = Image::make($p1->getRealPath());  
                $image_resize_p1->resize(400,400);
                $path_for_save = public_path('img_prod_p1/'). $name_image;
                $image_resize_p1->save(public_path('img_prod_p1/' .$name_image),40); 
                $final_path = path_save($path_for_save);
                if ($data_img_prod != NULL) {
                    //if file available
                    $name_img =  $data_img_prod->image_name;
                    $cek_file_p1 = File::exists(public_path('img_prod_p1/'.$name_img));
                    if ($cek_file_p1) {
                        unlink(public_path('img_prod_p1')."/".$name_img);
                    }
                    //if file available
                    $data_img_prod->image_name = $name_image;
                    $data_img_prod->path = $final_path;
                    $data_img_prod->save();
                   
                }else{
                    $img_prod = new ProductImage();
                    $img_prod->image_name = $name_image;
                    $img_prod->id_product = $idprod;
                    $img_prod->path = $final_path;
                    $img_prod->save();
                   
                }
            }
       }
    }
    public function store(Request $request)
    {
        //
        $name = $request->name;
        $img = $request->file('image');
        $price = $request->price;
        if ($img != NULL) {
            $width_img = Image::make($img->getRealPath())->width();
            $height_img =  Image::make($img->getRealPath())->height();
            $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$name.'.webp';
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
                $idProd = $product->id;
                $p1 = $request->file('image_p1');
                $p2 = $request->file('image_p2');
                $p3 = $request->file('image_p3');
                $isCreate = true;
                $this->uploadImage1Product($idProd,$p1,$isCreate);
                $this->uploadImage2Product($idProd,$p2,$isCreate);
                $this->uploadImage3Product($idProd,$p3,$isCreate);
                return response()->json([
                    'message' => 'success create',
                    'product_id_insert'=>$product->id
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
        $prod = Product::find($id);
        $other_image = ProductImage::query()->where('id_product',$id)->get();
        if ($prod != NULL) {
            return response()->json([
                'id_product'=>$id,
                'message' => 'product  found',
                'name_product' => $prod->name_product,
                'price' =>$prod->price,
                'img_front' => $prod->picture,
                'image_other'=>[

                ]
            ],200);
        }else{
            return response()->json([
                'id_product'=>$id,
                'message' => 'id product '.$id.' not found'
            ],400);
        }
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
        $p1 = $request->file('image_p1');
        $p2 = $request->file('image_p2');
        $p3 = $request->file('image_p3');
        $findProduct = Product::query()->where('id',$id)->first();
        if ($findProduct != NULL) {
            $search = Product::query()->where('id',$id)->first();
            if ($request->name_product != NULL) {
                $search->name_product = $request->name_product;   
            }
            if ($request->file('image') != NULL) {
                $img_name = $search->picture;
                $cek_file = File::exists(public_path('image_product/'.$img_name));
                if ($cek_file) {
                    unlink(public_path('image_product')."/".$img_name);
                    $img = $request->file('image');
                    $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$request->name_product.'.webp';
                    $image_resize = Image::make($img->getRealPath());  
                    $image_resize->resize(200, 200);
                    $image_resize->save(public_path('image_product/' .$name_image),40);
                    $search->picture = $name_image;
                }else{
                    $img = $request->file('image');
                    $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$request->name_product.'.webp';
                    $image_resize = Image::make($img->getRealPath());  
                    $image_resize->resize(200, 200);
                    $image_resize->save(public_path('image_product/' .$name_image),40);
                    $search->picture = $name_image;
                }
            }
            if ($request->price != NULL) {
                if(!is_numeric($request->price)){
                    return response()->json([
                        'message' => 'error',
                        'validation'=>[
                            'msg1'=> 'input price just number 0 - 9'
                        ]
                    ],400);
                }else{
                    $search->price = $request->price;
                }
                
            }
            $isCreate = false;
            $this->uploadImage1Product($id,$p1,$isCreate);
            $this->uploadImage2Product($id,$p2,$isCreate);
            $this->uploadImage3Product($id,$p3,$isCreate);
           
            if ($search->save()) {
                return response()->json([
                    'message' => 'update successfully',
                    'id_product'=>$id
                ],200);
            }else{
                return response()->json([
                    'message' => 'update failed',
                ],400);
            }
        }else{
            return response()->json([
                'message' => 'id product not found',
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delemetImageProductP1($id)
    {   
        $data_img_prod_p1 = ProductImage::query()->where('id_product',$id)->where('image_name','like', '%' . 'p1' . '%')->first();
        if ($data_img_prod_p1 != NULL) {
            $name_image = $data_img_prod_p1->image_name;
            $cek_file = File::exists(public_path('img_prod_p1/'.$name_image));
            if ($cek_file) {
                unlink(public_path('img_prod_p1')."/".$name_image);
            }
            ProductImage::where('id',$data_img_prod_p1->id)->delete();
        } 
    }
    public function delemetImageProductP2($id)
    {
        $data_img_prod_p2 = ProductImage::query()->where('id_product',$id)->where('image_name','like', '%' . 'p2' . '%')->first();
        if ($data_img_prod_p2 != NULL) {
            $name_image = $data_img_prod_p2->image_name;
            $cek_file = File::exists(public_path('img_prod_p2/'.$name_image));
            if ($cek_file) {
                unlink(public_path('img_prod_p2')."/".$name_image);
            }
            ProductImage::where('id',$data_img_prod_p2->id)->delete();
          
        }
    }
    public function delemetImageProductP3($id)
    {
        $data_img_prod_p3 = ProductImage::query()->where('id_product',$id)->where('image_name','like', '%' . 'p3' . '%')->first();
        if ($data_img_prod_p3 != NULL) {
            $name_image = $data_img_prod_p3->image_name;
            $cek_file = File::exists(public_path('img_prod_p3/'.$name_image));
            if ($cek_file) {
                unlink(public_path('img_prod_p3')."/".$name_image);
            }
            ProductImage::where('id',$data_img_prod_p3->id)->delete();
        }
    }
    public function deleteProduct(Request $request)
    {
        $search = Product::query()->where('id',$request->id)->first();
        if ($search != NULL) {
            $img_name = $search->picture;
            $cek_file = File::exists(public_path('image_product/'.$img_name));
            $this->delemetImageProductP3($request->id);
            $this->delemetImageProductP2($request->id);
            $this->delemetImageProductP1($request->id);
            if ($cek_file) {
                unlink(public_path('image_product')."/".$img_name);
                DB::table('p1_product')->where('id', $request->id)->delete();
                return response()->json([
                    'message' => 'delete successfully',
                    'validation'=>[
                        'msg1'=> 'main image already deleted',
                        'id_product'=>$request->id
                    ]
                ],200);
                
            }else{
                DB::table('p1_product')->where('id', $request->id)->delete();
                return response()->json([
                    'message' => 'delete successfully',
                    'validation'=>[
                        'msg1'=> 'image not found',
                        'id_product'=>$request->id
                    ]
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'delete failed',
                'validation'=>[
                    'error'=> 'data not found',
                    'id_product'=>$request->id
                ]
            ],401);
        }
    }

    public function sadfasdf()
    {

    }
    public function destroy(Request $request, $id)
    {
        //
        $idInput = $request->id; 
       
    }
}
