<?php 
namespace App\Repository\K1\GenerateNewTransaction;

interface GenerateTransRepo{
    public function GenerateNewTransaction($data);
    public function UpdateGenerateTransaction($kode,$status);
}