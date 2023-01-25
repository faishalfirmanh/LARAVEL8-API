<?php

namespace App\Http\Controllers\API\K1;

use App\Http\Controllers\Controller;
use App\Http\Requests\K1_TransRequest;
use Illuminate\Http\Request;
use App\Service\K1\TransactionDetail\TransactionDetailServ;
class TransactionControllerK1 extends Controller
{
    //
    private $service_transaction;
    public function __construct(TransactionDetailServ $service_transaction)
    {
        $this->service_transaction = $service_transaction;
    }

    /**
     * Store a new blog post.
     *
     * @param  \App\Http\Requests\K1_Trans  $request
     * @return Illuminate\Http\Response
    */
    public function GenerateNewTransaction_con(Request $request)
    {
        $new_code = date('Y-m-d h:i:sa');
        $code_trans = str_replace(" ","_",str_replace(":","",str_replace("-","",$new_code)));
        $post = $this->service_transaction->GenerateNewTransService($code_trans);
        return $post;
    }

    public function PostTransaction_con(K1_TransRequest $request)
    {
        $tes = $request->validated();
        $res = array_key_exists('errors', $tes);
        if ($res == false) {
            $data = $this->service_transaction->PostTransactionDetailService($request);
            return $data;
        }
    }
}
