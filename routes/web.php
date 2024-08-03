<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\PriceQuoteController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\DragDropController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Area\AreaController;
use App\Http\Controllers\Commission\CommissionController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\TaskController;
use App\Http\Controllers\Receivable\PaymentController;
use App\Http\Controllers\Receivable\ReceiptController;
use App\Http\Controllers\Receivable\ReceivableController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\ServiceExpireController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Banner\BannerController;
use App\Http\Controllers\HouseHolder\HouseHolderController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CategoryPost\CategoryPostController;
use App\Http\Controllers\Filter\FilterController;
use App\Http\Controllers\Filter\FilterTypeController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Service\CategoryServiceController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/composer-update', [AuthController::class, 'composerUpdate']);

Route::get('/login', [AuthController::class, 'login'])->name('auth');



//Route::get('/addtk', function () {
//    \App\Models\User::create([
//        'first_name' => 'admin',
//        'last_name' => '',
//        'email' => 'kythuat@bivaco.net',
//        'phone' => '0969621079',
//        'password' => \Illuminate\Support\Facades\Hash::make('adminbivaco'),
//    ]);
//});



Route::post('/login', [AuthController::class, 'loginSubmit'])->name('auth.submit');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::post('/statistic', [HomeController::class, 'statistic'])->name('home.statistic');


    //Banner
    Route::prefix('banner')
        ->controller(BannerController::class)
        ->name('banner.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::post('/get-list-role', 'getListRole')->name('getListRole');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });


    //user
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::post('/get-list-role', [UserController::class, 'getListRole'])->name('user.getListRole');
        Route::get('/export', [UserController::class, 'export'])->name('user.export');
    });

    //department
    Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index')->middleware('permission:manager,view');
        Route::get('/create', [DepartmentController::class, 'create'])->name('department.create')->middleware('permission:manager,add');
        Route::post('/store', [DepartmentController::class, 'store'])->name('department.store')->middleware('permission:manager,add');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit')->middleware('permission:manager,edit');
        Route::post('/update/{id}', [DepartmentController::class, 'update'])->name('department.update')->middleware('permission:manager,edit');
        Route::delete('/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete')->middleware('permission:manager,delete');
    });

    //role
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('permission:manager,view');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:manager,add');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:manager,add');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:manager,edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:manager,edit');
        Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete')->middleware('permission:manager,delete');
    });

    //project
    Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('/project/update/{id}', [ProjectController::class, 'update'])->name('project.update');

    //task
    Route::get('/task', [TaskController::class, 'index'])->name('task.index');
    Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
    Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('task.edit');
    Route::post('/task/update/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::post('/task/getMember', [TaskController::class, 'getMember'])->name('task.getMember');

    //customer
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::post('/getPriceSv', [CustomerController::class, 'getPriceSv'])->name('customer.getPriceSv');
        Route::post('/upload', [CustomerController::class, 'uploadFile'])->name('customer.upload');
        Route::post('/remove', [CustomerController::class, 'removeFile'])->name('customer.remove');
        Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::get('/detail/{id}', [CustomerController::class, 'detail'])->name('customer.detail');
        Route::get('/detail-dialog/{id}', [CustomerController::class, 'dialog'])->name('customer.dialog');
        Route::get('/download-file/{id}/{file_name}', [CustomerController::class, 'download'])->name('customer.download');
        Route::delete('/delete-file/{file_id}', [CustomerController::class, 'deleteFile'])->name('customer.deleteFile');
        Route::post('/toggle/status', [CustomerController::class, 'toggleStatus'])->name('customer.toggleStatus');

        Route::post('/create-dialog/{id}', [CustomerController::class, 'createDialog'])->name('customer.createDialog');
        Route::post('/update-dialog/{id}', [CustomerController::class, 'updateDialog'])->name('customer.updateDialog');
        Route::delete('/delete-dialog/{id}', [CustomerController::class, 'deleteDialog'])->name('customer.deleteDialog');

        //service
        Route::post('/update-service/{id}', [CustomerController::class, 'updateService'])->name('customer.updateService');

        Route::post('/upfile-detail/{id}', [CustomerController::class, 'uploadDetail'])->name('customer.uploadDetail');

        Route::post('/check-date-and-type', [CustomerController::class, 'checkDateAndTypeByService'])->name('customer.checkDateAndTypeByService');
        Route::get('/export', [CustomerController::class, 'export'])->name('customer.export');
    });

    // order
    Route::prefix('order')
        ->controller(OrderController::class)
        ->name('order.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/update-type/{id}', 'update')->name('updateType');
            Route::get('/export', 'export')->name('export');
        });

    //service
    Route::group(['prefix' => 'service'], function () {
        Route::get('/', [ServiceController::class, 'index'])->name('service.index');
        Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
        Route::delete('/destroyImage/{id}', [ServiceController::class, 'destroyImage'])->name('service.destroyImage');
    });

    //receivable
    Route::group(['prefix' => 'receivable'], function () {
        Route::get('/', [ReceivableController::class, 'index'])->name('receivable.index');
        Route::get('/create', [ReceivableController::class, 'create'])->name('receivable.create');
        Route::post('/store', [ReceivableController::class, 'store'])->name('receivable.store');
        Route::get('/edit/{id}', [ReceivableController::class, 'edit'])->name('receivable.edit');
        Route::post('/update/{id}', [ReceivableController::class, 'update'])->name('receivable.update');
        Route::delete('/delete/{id}', [ReceivableController::class, 'delete'])->name('receivable.delete');

        Route::post('/get-list-service', [ReceivableController::class, 'getListService'])->name('receivable.getListService');
        Route::post('/add-form', [ReceivableController::class, 'addForm'])->name('receivable.addForm');

        //gia hạn
        Route::get('/create-extend', [ReceivableController::class, 'createExtend'])->name('receivable.createExtend');
        Route::post('/store-extend', [ReceivableController::class, 'storeExtend'])->name('receivable.storeExtend');
        Route::get('/edit-extend/{id}', [ReceivableController::class, 'editExtend'])->name('receivable.editExtend');
        Route::post('/update-extend/{id}', [ReceivableController::class, 'updateExtend'])->name('receivable.updateExtend');
        Route::post('/add-form-extend', [ReceivableController::class, 'addFormExtend'])->name('receivable.addFormExtend');
        Route::get('/export', [ReceivableController::class, 'export'])->name('receivable.export');
    });

    //price quote
    Route::group(['prefix' => 'price-quote'], function () {
        Route::get('/', [PriceQuoteController::class, 'index'])->name('priceQuote.index');
        Route::get('/create', [PriceQuoteController::class, 'create'])->name('priceQuote.create');
        Route::post('/store', [PriceQuoteController::class, 'store'])->name('priceQuote.store');
        Route::get('/edit/{id}', [PriceQuoteController::class, 'edit'])->name('priceQuote.edit');
        Route::post('/update/{id}', [PriceQuoteController::class, 'update'])->name('priceQuote.update');
        Route::delete('/delete/{id}', [PriceQuoteController::class, 'delete'])->name('priceQuote.delete');


        Route::get('/detail/{id}', [PriceQuoteController::class, 'detail'])->name('priceQuote.detail');
        Route::get('/exportPdf/{id}', [PriceQuoteController::class, 'exportPdf'])->name('priceQuote.exportPdf');
        Route::post('/send', [PriceQuoteController::class, 'send'])->name('priceQuote.send');

    });

    //receipt
    Route::group(['prefix' => 'receipt'], function () {
        Route::get('/', [ReceiptController::class, 'index'])->name('receipt.index');
        Route::get('/create', [ReceiptController::class, 'create'])->name('receipt.create');
        Route::post('/store', [ReceiptController::class, 'store'])->name('receipt.store');
        Route::get('/edit/{id}', [ReceiptController::class, 'edit'])->name('receipt.edit');
        Route::post('/update/{id}', [ReceiptController::class, 'update'])->name('receipt.update');
        Route::delete('/delete/{id}', [ReceiptController::class, 'delete'])->name('receipt.delete');

        Route::post('/getAddress', [ReceiptController::class, 'getAddress'])->name('receipt.getAddress');
        Route::get('/printf/{id}', [ReceiptController::class, 'printf'])->name('receipt.printf');
        Route::get('/export', [ReceiptController::class, 'export'])->name('receipt.export');
    });

    //payment
    Route::group(['prefix' => 'payment'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/create', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/store', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::post('/update/{id}', [PaymentController::class, 'update'])->name('payment.update');
        Route::delete('/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');
        Route::get('/printf/{id}', [PaymentController::class, 'printf'])->name('payment.printf');
        Route::get('/export', [PaymentController::class, 'export'])->name('payment.export');
    });

    //supplier
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

    });

    //noti
    Route::group(['prefix' => 'noti'], function () {
        Route::get('/one-day', [ServiceExpireController::class, 'expireOneDay'])->name('noti.oneDay');
        Route::get('/seven-day', [ServiceExpireController::class, 'expireSevenDay'])->name('noti.sevenDay');
        Route::get('/thirty-day', [ServiceExpireController::class, 'expirethirtyDay'])->name('noti.thirtyDay');
    });

    // householder
    Route::prefix('householder')
        ->controller(HouseHolderController::class)
        ->name('householder.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/export', 'export')->name('export');
        });

    // categoryPost
    Route::prefix('categoryPost')
        ->controller(CategoryPostController::class)
        ->name('categoryPost.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });


    // categoryService
    Route::prefix('categoryService')
        ->controller(CategoryServiceController::class)
        ->name('categoryService.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });

    // commission
    Route::prefix('commission')
        ->controller(CommissionController::class)
        ->name('commission.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/commissionBonus', 'listCommissionBonus')->name('commissionBonus');
            Route::get('/export', 'export')->name('commissionBonus.export');
        });


    // area
    Route::prefix('area')
        ->controller(AreaController::class)
        ->name('area.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });


    // post
    Route::prefix('post')
        ->controller(PostController::class)
        ->name('post.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });


    // setting
    Route::prefix('setting')
        ->controller(SettingController::class)
        ->name('setting.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });

        //filter type

        Route::prefix('filter_type')
        ->controller(FilterTypeController::class)
        ->name('filter_type.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });


        //filter
        Route::prefix('filter')
        ->controller(FilterController::class)
        ->name('filter.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
            Route::post('/change-active', 'changeActive')->name('changeActive');
            Route::post('/change-hot', 'changeHot')->name('changeHot');
        });


    //ajax
    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
        Route::group(['prefix' => 'address'], function () {
            Route::get('district', [AddressController::class, 'getDistricts'])->name('ajax.address.districts');
            Route::get('communes', [AddressController::class, 'getCommunes'])->name('ajax.address.communes');
            Route::get('district-service', [AddressController::class, 'getDistrictsService'])->name('ajax.address.districts-service');
            Route::get('communes-service', [AddressController::class, 'getCommunesService'])->name('ajax.address.communes-service');
        });
    });
});
