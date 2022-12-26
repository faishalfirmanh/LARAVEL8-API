<?php

namespace App\Http\Controllers\API\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P1\Product;
use App\Models\P1\ProductImage;
use App\Models\P1\Category;
use App\Models\P1\OnlineShop;
use App\Models\P1\LinkOnlineShopProduct;
use Image;
use File;
use App\Models\P1\UserApi;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchProduct(Request $request)
    {
         $limit = 5;
         $input_keyword = $request->keyword;
         $page = $request->page == null ? 1 : $request->page;
         if (!empty($input_keyword)) {
            $all_data = Product::query()
                ->select('p1_product.id','p1_product.name_product','p1_product.id_category','p1_product.description', 'p1_category_product.id','p1_category_product.name')
                ->join('p1_category_product','p1_product.id_category','p1_category_product.id')
                ->where('p1_product.name_product','like','%'.$input_keyword.'%')
                ->orWhere('p1_product.description','like','%'.$input_keyword.'%')
                ->orWhere('p1_category_product.name', 'like','%'.$input_keyword.'%')
                ->get();
            $data = Product::query()
            ->select('p1_product.id','p1_product.price','p1_product.name_product','p1_product.id_category','p1_product.description', 'p1_category_product.id','p1_category_product.name')
            ->join('p1_category_product','p1_product.id_category','p1_category_product.id')
            ->where('p1_product.name_product','like','%'.$input_keyword.'%')
            ->orWhere('p1_product.description','like','%'.$input_keyword.'%')
            ->orWhere('p1_category_product.name', 'like','%'.$input_keyword.'%')
            ->limit($limit)
            ->paginate($limit);
            // ->get();
            $list_data_search_product = array();
            $total_page = (count($all_data) / $limit);
            
            $ss = 0;
            if (intval($total_page) < 1) {
                $ss += 1; 
            }else{
                $ss = (count($all_data) / $limit)+1; 
            }
            if (sizeof($data)>0) {
                foreach ($data as $key) {
                    array_push($list_data_search_product,$key);
                }
                return response()->json([
                    'message'=>'data found',
                    'data' => $list_data_search_product,
                    'meta'=>[
                        'total_data'=>count($all_data),
                        'perpage'=>intval($limit),
                        'current_page'=>$page,
                        'total_page' => intval($ss),
                    ]
                ],200);
            }else{
                return response()->json([
                    'message'=>'data not found',
                    'validation'=>[
                        'condition'=> 'data not found or page is over'
                    ]
                ],404);
            }
        }
    }
    public function getDataAllProduct(Request $request)//all product with param page
    {
        $page = intval($request->page);
        if ($page == null) $page = 1;
        $category = $request->category;
        $limit = 5;
        $img_product =  url('/').'/'.'image_product'.'/';
        
        $all_data = Product::query()->select('name_product','picture','price')->get();
        $data = Product::query()->select('id','name_product','picture','price')->limit($limit)->paginate($limit);
       // $data_limit_get =  $all_data = Product::query()->select('name_product','picture','price')->get();
        $var = array();
        foreach ($data as $key) {
           $key->name_product;
           $key->picture = $img_product.$key->picture;
           $key->price = "Rp ". number_format($key->price,2);
           array_push($var,$key);
        }
        $total_page = (count($all_data) / $limit)+1;
        return response()->json([
            'data' => $var,
            'meta'=>[
                'total_data'=>count($all_data),
                'perpage'=>intval($limit),
                'current_page'=>$page,
                'total_page' => intval($total_page),
            ]
        ],200);
    }
    public function getDataProductById(Request $request){//detail product
        $id = $request->id;
        $product = Product::find($id);
        if (cek_ProductById($id) == 'null product') {
            return response()->json([
                'message' => 'product no found',
                'validation'=>[
                    'id_product'=> $id
                ]
            ],404);
        }
       
        $img = $product->listImageProduct;
        $list_Img = array();
        foreach ($img as $key) {
            array_push($list_Img, $key->path);
        }

        $link = $product->listUrlOnlineShop;
        $list_Url = array();
        $list_nameMarket = array();
        
        foreach ($link as $key) {
            array_push($list_Url, $key->url);
            if (cek_NameMareketBaseOnUrl($key->url) != NULL) {
                array_push($list_nameMarket,cek_NameMareketBaseOnUrl($key->url));
            }

        }
        $key_value_marketplace = array_combine($list_nameMarket,$list_Url);
       
        
        return response()->json([
            'message' => 'product found',
            'name user'=> cek_nameUserById($product->id_user),
            'category_product'=>cek_CategoryProductById($product->id_category),
            'name_product'=>$product->name_product,
            'price'=>$product->price,
            'description'=>$product->description,
            'image'=> $list_Img,
            'marketplace'=>$key_value_marketplace
        ],200);
       
      
       
    }
    public function index(Request $request)
    {
        //
       
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

     public function deleteLinkMarketPlace(Request $request){
        if (cek_LinkMarketById($request->id) != 'null link') {
            DB::table('p1_productlinkonlineshop')->where('id', $request->id)->delete();
                return response()->json([
                    'message' => 'delete link onlineshop product successfully',
                    'validation'=>[
                        'id_link'=>$request->id
                    ]
                ],200);
        }else{
            return response()->json([
                'message' => 'delete link onlineshop product failed',
                'validation'=>[
                    'id_link'=> 'id '.$request->id .' not found'
                ]
            ],400);
        }
     }

     public function addLinkMarketplaceToProduct(Request $request){
       
        $idOnlineShop = $request->idOnlineShop;
        $idProd = $request->idProd;
        $url = $request->url;
        $isCreate = $request->isCreate;
        $id_link = $request->idlink;

        //--------cek data is null----------
        if (cek_ProductById($idProd) == 'null product') {
            return response()->json([
                'message' => 'product no found',
                'validation'=>[
                    'id_product'=> $idProd
                ]
            ],404);
        }
        if(cek_marketplaceById($idOnlineShop) == 'null marketplace') {
            return response()->json([
                'message' => 'marketplace no found',
                'validation'=>[
                    'id'=> $idOnlineShop
                ]
            ],404);
        }
         //--------cek data is null----------
        $searchAllData = LinkOnlineShopProduct::query()->where('id_onlineshop',$idOnlineShop)->where('id_product',$idProd)->get();
        if ($isCreate == '1') {//create
            if (count($searchAllData)<1) {
                $linkToMarket = new LinkOnlineShopProduct;
                $linkToMarket->id_onlineshop = $idOnlineShop;
                $linkToMarket->id_product = $idProd;
                $linkToMarket->url = $url;
                if ($linkToMarket->save()){
                    return response()->json([
                        'message' => 'create new link product successfully',
                        'validation'=>[
                            'name_product'=> cek_ProductById($idProd)->name_product,
                            'name_market'=>cek_marketplaceById($idOnlineShop)->name
                        ]
                    ],200);
                }
            }else{
                return response()->json([
                    'message' => 'failed create new link product',
                    'validation'=>[
                        'msg_1'=>'one product has only one online store link',
                        'name_market'=>cek_marketplaceById($idOnlineShop)->name,
                        'name_product'=>cek_ProductById($idProd)->name_product,
                        'notif'=> 'is already registered'
                    ],
                ],200);
            }
        }else{//edit
            $searchFirstData = LinkOnlineShopProduct::query()->where('id',$id_link)->first();
            if (cek_LinkMarketById($id_link) == 'null link') {
                return response()->json([
                    'message' => 'id link marketplace no found',
                    'validation'=>[
                        'id'=> $id_link
                    ]
                ],404);
            }
            //compare by input and id is not myself
            $cobaLagi =  LinkOnlineShopProduct::query()->where('id_onlineshop',$idOnlineShop)->where('id_product',$idProd)->where('id','!=',$id_link)->first();
            
            if ($idOnlineShop != $searchFirstData->id_onlineshop || $idProd != $searchFirstData->id_product) {
                if (count($searchAllData)> 1) { //jika semua data
                    return response()->json([
                        'message' => 'failed update link product',
                        'validation'=>[
                            'msg1'=> 'one product has only one online store link',
                        ]
                    ],400);
                }else if(count($searchAllData) == 1) { //jika ada data double
                   if ($cobaLagi != NULL) {
                        return response()->json([
                            'message' => 'failed update link product',
                            'validation'=>[
                                'msg1'=> 'one product has only one online store link',
                            ]
                        ],400);
                   }
                }
            }

            $searchFirstData->id_onlineshop = $idOnlineShop;
            $searchFirstData->id_product = $idProd;
          
            if (!empty($url)){
                $searchFirstData->url = $url;
            }
            if ($searchFirstData->save()) {
                return response()->json([
                    'message' => 'update new link product successfully',
                    'validation'=>[
                        'name_product'=> cek_ProductById($idProd)->name_product,
                        'name_market'=>cek_marketplaceById($idOnlineShop)->name
                    ]
                ],200);
            }
        }
     }

     public function uploadImage2Product($idprod,$p2,$isCreate){
        $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_p2_'.$idprod.'.webp';
        if ($isCreate === true) {
            if($p2 != NULL){
                $image_resize_p2 = Image::make($p2->getRealPath());  
                $image_resize_p2->resize(400, 400);
                $image_resize_p2->save(public_path('img_prod_p2/' .$name_image),40); 
                $path_for_save = public_path('img_prod_p2/'). $name_image;
                $final_path = cekStringSubCobalagi(path_save($path_for_save));
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
                $final_path = cekStringSubCobalagi(path_save($path_for_save));
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
                $final_path = cekStringSubCobalagi(path_save($path_for_save));
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
                $final_path = cekStringSubCobalagi(path_save($path_for_save));
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
                $final_path = cekStringSubCobalagi(path_save($path_for_save));
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
        $input_category = $request->id_category;
        if ($img != NULL) {
            $width_img = Image::make($img->getRealPath())->width();
            $height_img =  Image::make($img->getRealPath())->height();
            $name_image = str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$name.'.webp';
            $image_resize = Image::make($img->getRealPath());  
            $image_resize->resize(200, 200);
            //$image_resize->crop(200, 200);
            //$img->move(public_path('storage/image_product'), $name_image); //upload image laravel
            $image_resize->save(public_path('image_product/' .cekStringAvailableSpace($name_image)),40); //upload image image intervention
            $product = new Product();
            $product->name_product = $name;
            if ($request->description != NULL) {
                $product->description  = $request->description;
            }
            if ($request->idUserLogin != null) {
                $searchIdUserlogin = UserApi::query()->where('id',$request->idUserLogin)->first();
                if ($searchIdUserlogin == NULL) {
                    return response()->json([
                        'message' => 'failed create',
                        'validation'=>[
                            'error'=> 'Id User Login Not found'
                        ]
                    ],404);   
                }
                $product->id_user = $request->idUserLogin;
            }
            $product->price = $price;
            $product->picture = cekStringAvailableSpace($name_image);
            if ($input_category != NULL) {
               $searchCategory =  Category::query()->where('id',$input_category)->first();
               if ($searchCategory == NULL) {
                    return response()->json([
                        'message' => 'failed create',
                        'validation'=>[
                            'error'=> 'Id Category Not found'
                        ]
                    ],404);   
               }
               $product->id_category = $input_category;
            }
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
        $input_category = $request->id_category;
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
                    $name_image = cekStringAvailableSpace(str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$request->name_product.'.webp');
                    $image_resize = Image::make($img->getRealPath());  
                    $image_resize->resize(200, 200);
                    $image_resize->save(public_path('image_product/' .$name_image),40);
                    $search->picture = cekStringAvailableSpace($name_image);
                }else{
                    $img = $request->file('image');
                    $name_image = cekStringAvailableSpace(str_replace(':','',str_replace(' ','_',str_replace('-','',date('Y-m-d h:i:s')))).'_'.$request->name_product.'.webp');
                    $image_resize = Image::make($img->getRealPath());  
                    $image_resize->resize(200, 200);
                    $image_resize->save(public_path('image_product/' .$name_image),40);
                    $search->picture = cekStringAvailableSpace($name_image);
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
            if ($request->description != NULL) {
                $search->description  = $request->description;
            }
            if ($request->idUserLogin != null) {
                $searchIdUserlogin = UserApi::query()->where('id',$request->idUserLogin)->first();
                if ($searchIdUserlogin == NULL) {
                    return response()->json([
                        'message' => 'failed update',
                        'validation'=>[
                            'error'=> 'Id User Login Not found'
                        ]
                    ],404);   
                }
                $search->id_user = $request->idUserLogin;
            }
            if ($input_category != NULL) {
                $searchCategory =  Category::query()->where('id',$input_category)->first();
                if ($searchCategory == NULL) {
                     return response()->json([
                         'message' => 'failed update',
                         'validation'=>[
                             'error'=> 'Id Category Not found'
                         ]
                     ],404);   
                }
                $search->id_category = $input_category;
             }
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
        $searchLinkByIdProd = LinkOnlineShopProduct::query()->where('id_product',$request->id)->get();
        if (sizeof($searchLinkByIdProd)>0) {
           foreach ($searchLinkByIdProd as $key) {
                LinkOnlineShopProduct::where('id',$key->id)->delete();
           }
        }
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
                        'id_product'=>$request->id,
                        'total_linkmarket_productdeleted'=> sizeof($searchLinkByIdProd),
                    ]
                ],200);
                
            }else{
                DB::table('p1_product')->where('id', $request->id)->delete();
                return response()->json([
                    'message' => 'delete successfully',
                    'validation'=>[
                        'msg1'=> 'image not found',
                        'id_product'=>$request->id,
                        'total_linkmarket_productdeleted'=> sizeof($searchLinkByIdProd),
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
