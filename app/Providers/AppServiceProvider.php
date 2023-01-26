<?php

namespace App\Providers;

use App\Repository\K1\Category\CategoryRepository;
use App\Repository\K1\Category\CategoryRepositoryImplement;
use App\Repository\K1\GenerateNewTransaction\GenerateTransRepo;
use App\Repository\K1\GenerateNewTransaction\GenerateTransRepoImpelemnt;
use App\Repository\K1\Product\ProductRepo;
use App\Repository\K1\Product\ProductRepoImplement;
use App\Repository\K1\ProductStock\ProductStockRepo;
use App\Repository\K1\ProductStock\ProductStockRepoImplement;
use App\Repository\K1\ProductSuppRelations\ProductSupRepo;
use App\Repository\K1\ProductSuppRelations\ProductSupRepoImplement;
use App\Repository\K1\Supplier\SupplierRepoImplement;
use App\Repository\K1\Supplier\SupplierRepo;
use App\Repository\K1\TransactionDetail\TransactionDetailRepository;
use App\Repository\K1\TransactionDetail\TransactionDetailRepositoryImplement;
use App\Repository\K1\User\UserRepository;
use App\Repository\K1\User\UserRepositoryImplement;
use App\Repository\K1\VoucherForTransaction\VoucherRepository;
use App\Repository\K1\VoucherForTransaction\VoucherRepositoryImplement;
use App\Service\K1\Category\CategoryService;
use App\Service\K1\Category\CategoryServiceImplement;
use App\Service\K1\Product\ProductService;
use App\Service\K1\Product\ProductServiceImplement;
use App\Service\K1\ProductStock\ProductStockService;
use App\Service\K1\ProductStock\ProductStockServiceImplement;
use App\Service\K1\Supplier\SupplierService;
use App\Service\K1\Supplier\SupplierServiceImplement;
use App\Service\K1\TransactionDetail\TransactionDetailServ;
use App\Service\K1\TransactionDetail\TransactionDetailServImplement;
use App\Service\K1\User\UserService;
use App\Service\K1\User\UserServiceImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //fungsi bind untuk mengikat  class terkait, agar bisa dikenali oleh laravel dan bisa diakses
        //user
        $this->app->bind(UserRepository::class, UserRepositoryImplement::class);
        $this->app->bind(UserService::class, UserServiceImplement::class);
        //category
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImplement::class); //1
        $this->app->bind(CategoryService::class, CategoryServiceImplement::class);//2
        //supplier
        $this->app->bind(SupplierRepo::class, SupplierRepoImplement::class);
        $this->app->bind(SupplierService::class, SupplierServiceImplement::class);
        //product
        $this->app->bind(ProductRepo::class, ProductRepoImplement::class);
        $this->app->bind(ProductService::class, ProductServiceImplement::class);
        $this->app->bind(ProductStockRepo::class, ProductStockRepoImplement::class);
        $this->app->bind(ProductStockService::class, ProductStockServiceImplement::class);
        $this->app->bind(ProductRepo::class, ProductRepoImplement::class);
        $this->app->bind(ProductSupRepo::class, ProductSupRepoImplement::class);
        //transaction
        /**generate new trnas 1  */
        $this->app->bind(GenerateTransRepo::class, GenerateTransRepoImpelemnt::class);
        $this->app->bind(TransactionDetailRepository::class, TransactionDetailRepositoryImplement::class);
        $this->app->bind(TransactionDetailServ::class, TransactionDetailServImplement::class);
        /**--------- Voucher ------*/
        $this->app->bind(VoucherRepository::class, VoucherRepositoryImplement::class);
        //transaction end
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
