<?php
namespace App\Service\K1\Supplier;

use App\Models\k1\K1_Supplier;
use App\Repository\K1\Supplier\SupplierRepo;
use App\Repostiory\K1\Supplier\SupplierRepository;
use Illuminate\Support\Facades\Validator;
use App\Rules\K1\Rules_category_name;
use App\Rules\K1\Rules_cek_phone_supplier;
use PhpParser\Node\Stmt\Else_;

class SupplierServiceImplement implements SupplierService{

    protected $repository_supplier;

    public function __construct(SupplierRepo $repository_supplier)
    {
        $this->repository_supplier = $repository_supplier;
    }

    public function getSupplierServicePaginate($data)
    {
        $page_input = $data->page == null ? 1 : intval($data->page);
        $all_data = $this->repository_supplier->getAllSupplier();
        $limit = 10;
        $data_limit = $this->repository_supplier->getSupplierPaginate($limit);
        $total_page = ceil((count($all_data) / 10));//always round up
        $var = array();
        foreach ($data_limit as $key) {
            unset($key->created_at);
            unset($key->updated_at);
            $key->id;
            $key->name;
            $key->phone_number;
            $key->name_pt;
            array_push($var,$key);
        }
        $next_url = $page_input < $total_page ? url()->current().'?page='.intval($page_input+1) : null;
        $prev_url = $page_input > 1  ? url()->current().'?page='.intval($page_input-1) : null;
        return response()->json([
            'status'=>count($var)>0 ? 'ok' : 'empty',
            'data'=>count($var)>0 ? $var : 'empty',
            'data_pagination'=>[
                'current_data_show'=>count($data_limit),
                'total_data'=>count($all_data),
                'perpage_or_limit'=>intval($limit),
                'current_page'=>intval($page_input),
                'total_page'=>$total_page,
                'next_url'=> $next_url,
                'prev_url'=>$prev_url
            ]
        ],count($var)>0 ? 200 : 404);
    }

    public function getPhoneSupplierService($data)
    {
        $validator = Validator::make($data->all(),[
            'phone_number'=> 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $cek = $this->repository_supplier->getPhoneSupplier($data->phone_number);
            if ($cek != NULL) {
                return response()->json([
                    'status'=>'ok',
                    'data'=>$cek,
                ],200);
            }else{
                return response()->json([
                    'status'=>'no',
                    'data'=>'not found',
                    'phone'=> $data->phone_number
                ],404);
            }
        }
       
    }
    public function getAllSupplierService()
    {
        $data = $this->repository_supplier->getAllSupplier();
        if ($data != NULL) {
            return response()->json([
                'status'=>'ok',
                'data'=>$this->repository_supplier->getAllSupplier()
            ],200);
        }
        else{
            return response()->json([
                'status'=>'no',
                'data'=>'empty'
            ],404);
        }
    }

    public function getSupplierByIdService($request)
    {
        $id = $request->id_supplier;
        $validator = Validator::make($request->all(),[
            'id_supplier'=> 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $data = $this->repository_supplier->getSupplierById($id);
            if ($data != NULL) {
                return response()->json([
                    'status'=>'ok',
                    'data'=>$data
                ],200);
            }else{
                return response()->json([
                    'status'=>'no',
                    'data'=>'empty',
                    'id'=>$id
                ],404);
            }
        }
    }

    public function postSupplierService($data)
    {
        $validator = Validator::make($data->all(),[
            'phone_number'=> ['required','numeric',new Rules_cek_phone_supplier],
            'name'=> 'required|string',
            'name_pt'=> 'required|string'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $result = $this->repository_supplier->postSupplier($data);
            return response()->json([
                'status'=>'ok',
                'data'=>$result
            ],200);
        }
    }

    public function updateSupplierService($request,$id, $name,$phone,$name_pt)
    {

        $validator = Validator::make($request->all(),[
            'id_supplier'=> ['required','numeric'],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $search_data = $this->repository_supplier->getSupplierById($id);
        if ($search_data != NULL) {
            $cek_phone  = cekInputSupplierPhone($search_data,$phone);
            $cek_name = cekInputSupplierName($search_data,$name);
            $cek_pt = cekInputSupplierPt($search_data,$name_pt);
           if (!empty($phone)) {
                $validator_phone = Validator::make($request->all(),[
                    'phone_number'=> ['required','numeric'],
                ]);
                if ($validator_phone->fails()) {
                    return $validator_phone->errors();
                }
              $phone_other_supplier = cekPhoneNumberSupplier($phone);
              if ($phone_other_supplier != null) {//if input phone not found at all
                //if input phone same with other people
                 if ($phone_other_supplier->phone_number != $search_data->phone_number) {
                    return response()->json([
                        'status'=>'failed update',
                        'data'=>'phone number is have someone else',
                        'phone'=>$phone,
                        'user'=>[
                            'name'=>$phone_other_supplier->name,
                            'phone'=>$phone_other_supplier->phone_number,
                            'id'=>$phone_other_supplier->id
                        ]
                    ],404);
                 }else{//input phone myself
                        $result = $this->repository_supplier->updateSupplier($id,$cek_name,$cek_phone,$cek_pt);
                        return response()->json([
                            'status'=>'update_success',
                            'data'=>$result
                        ],200);
                 }
              }else{//input new phone
                    $result = $this->repository_supplier->updateSupplier($id,$cek_name,$cek_phone,$cek_pt);
                    return response()->json([
                        'status'=>'update_success',
                        'data'=>$result
                    ],200);
              }
           }else{
                //if input phone empty
                $result = $this->repository_supplier->updateSupplier($id,$cek_name,$cek_phone,$cek_pt);
                return response()->json([
                    'status'=>'update_success',
                    'data'=>$result
                ],200);
           }
        }else{
            return response()->json([
                'status'=>'update_failed',
                'data'=>'data no found',
                'id'=>$id
            ],404);
        }

    }

    public function deleteSupplierService($id)
    {
        $validator = Validator::make($id->all(),[
            'id_supplier'=> 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
            $find = $this->repository_supplier->getSupplierById($id->id_supplier);
            if ($find != NULL) {
                if (cekSupplierRelationProdByIdSupplier($id->id_supplier) != NULL) {
                    return response()->json([
                        'status'=>'supplier is have realtions',
                        'data' => 'deleted failed',
                        'id'=>$id->id_supplier
                    ],404);
                }else{
                    $deleted = $this->repository_supplier->deleteSupplier($id->id_supplier);
                    return response()->json([
                        'status'=>'deleted_success',
                        'id'=>$id->id_supplier
                    ],200);
                }
            }else{
                return response()->json([
                    'status'=>'deleted_failed',
                    'data'=>'data no found',
                    'id'=>$id->id_supplier
                ],404);
            }
        }
    }

}