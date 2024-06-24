<?php

use Inertia\Inertia;
use App\Models\Invoice;
use App\Models\Currency;
use App\Models\OnlyDebt;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\System\TrashController;
use App\Http\Controllers\System\UsersController;
use App\Http\Controllers\System\PrintsController;
use App\Http\Controllers\System\DebtorsController;
use App\Http\Controllers\System\OfficesController;
use App\Http\Controllers\System\GetDebtsController;
use App\Http\Controllers\System\InvoicesController;
use App\Http\Controllers\System\OffDebtsController;
use App\Http\Controllers\System\ProductsController;
use App\Http\Controllers\Permission\RolesController;
use App\Http\Controllers\System\CustomersController;
use App\Http\Controllers\System\OnlyDebtsController;
use App\Http\Controllers\System\CategoriesController;
use App\Http\Controllers\System\CurrenciesController;
use App\Http\Controllers\System\InvoiceBuysController;
use App\Http\Controllers\System\RepDebtsController;
use App\Http\Controllers\System\SellersController;
use App\Models\InvoiceBuy;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth', 'check-permission'])->group(function () {
    Route::resources([
        'users' => UsersController::class,
        'roles' => RolesController::class,
        'categories' => CategoriesController::class,
        'categories.products' => ProductsController::class,
        'customers' => CustomersController::class,
        'customers.getdebts' => GetDebtsController::class,
        'getdebts.invoices' => InvoicesController::class,
        'offices' => OfficesController::class,
        'offices.offdebts' => OffDebtsController::class,
        'debtors' => DebtorsController::class,
        'debtors.onlydebts' => OnlyDebtsController::class,
        'sellers' => SellersController::class,
        'sellers.repdebts' => RepDebtsController::class,
        'repdebts.invoicebuys' => InvoiceBuysController::class,
    ]);
   Route::controller(TrashController::class)->group(function () {
        Route::put('category/type_delete/{category}','category_delete')->name('category.type_delete');
        Route::put('product/type_delete/{product}','product_delete')->name('product.type_delete');
        Route::put('customer/type_delete/{customer}','customer_delete')->name('customer.type_delete');
        Route::put('seller/type_delete/{seller}','seller_delete')->name('seller.type_delete');
        Route::put('office/type_delete/{office}','office_delete')->name('office.type_delete');
        Route::put('debtor/type_delete/{debtor}','debtor_delete')->name('debtor.type_delete');
        Route::put('getdebt/type_delete/{getdebt}','getdebt_delete')->name('getdebt.type_delete');
        Route::put('getdebt/type_delete/inv/{getdebt}','getdebt_delete_inv')->name('getdebt.type_delete.inv');
        Route::put('offdebt/type_delete/{offdebt}','offdebt_delete')->name('offdebt.type_delete');
        Route::put('onlydebt/type_delete/{onlydebt}','onlydebt_delete')->name('onlydebt.type_delete');
        Route::put('category/type_restore/{category}','category_restore')->name('category.type_restore');
        Route::put('product/type_restore/{product}','product_restore')->name('product.type_restore');
        Route::put('customer/type_restore/{customer}','customer_restore')->name('customer.type_restore');
        Route::put('seller/type_restore/{seller}','seller_restore')->name('seller.type_restore');
        Route::put('office/type_restore/{office}','office_restore')->name('office.type_restore');
        Route::put('debtor/type_restore/{debtor}','debtor_restore')->name('debtor.type_restore');
        Route::put('getdebt/type_restore/{getdebt}','getdebt_restore')->name('getdebt.type_restore');
        Route::put('offdebt/type_restore/{offdebt}','offdebt_restore')->name('offdebt.type_restore');
        Route::put('onlydebt/type_restore/{onlydebt}','onlydebt_restore')->name('onlydebt.type_restore');
        Route::get('category/trash_show','category_show')->name('category.trash_show');
        Route::get('product/trash_show','product_show')->name('product.trash_show');
        Route::get('customer/trash_show','customer_show')->name('customer.trash_show');
        Route::get('seller/trash_show','seller_show')->name('seller.trash_show');
        Route::get('office/trash_show','office_show')->name('office.trash_show');
        Route::get('debtor/trash_show','debtor_show')->name('debtor.trash_show');
        Route::get('getdebt/trash_show','getdebt_show')->name('getdebt.trash_show');
        Route::get('offdebt/trash_show','offdebt_show')->name('offdebt.trash_show');
        Route::get('onlydebt/trash_show','onlydebt_show')->name('onlydebt.trash_show');
        Route::put('category/type_restore_all','category_restore_all')->name('category.type_restore_all');
        Route::delete('category/type_delete_all','category_delete_all')->name('category.type_delete_all');
        Route::put('product/type_restore_all','product_restore_all')->name('product.type_restore_all');
        Route::delete('product/type_delete_all','product_delete_all')->name('product.type_delete_all');
        Route::put('customer/type_restore_all','customer_restore_all')->name('customer.type_restore_all');
        Route::delete('customer/type_delete_all','customer_delete_all')->name('customer.type_delete_all');
        Route::put('seller/type_restore_all','seller_restore_all')->name('seller.type_restore_all');
        Route::delete('seller/type_delete_all','seller_delete_all')->name('seller.type_delete_all');
        Route::put('office/type_restore_all','office_restore_all')->name('office.type_restore_all');
        Route::delete('office/type_delete_all','office_delete_all')->name('office.type_delete_all');
        Route::put('debtor/type_restore_all','debtor_restore_all')->name('debtor.type_restore_all');
        Route::delete('debtor/type_delete_all','debtor_delete_all')->name('debtor.type_delete_all');
        Route::put('getdebt/type_restore_all','getdebt_restore_all')->name('getdebt.type_restore_all');
        Route::delete('getdebt/type_delete_all','getdebt_delete_all')->name('getdebt.type_delete_all');
        Route::put('offdebt/type_restore_all','offdebt_restore_all')->name('offdebt.type_restore_all');
        Route::delete('offdebt/type_delete_all','offdebt_delete_all')->name('offdebt.type_delete_all');
        Route::delete('onlydebt/type_delete_all','onlydebt_delete_all')->name('onlydebt.type_delete_all');
        Route::put('onlydebt/type_restore_all','onlydebt_restore_all')->name('onlydebt.type_restore_all');
   });
   Route::controller(InvoicesController::class)->group(function () {
        Route::get('/invoices/create' ,'BeforeCreate')->name('before.create.invoice');
        Route::post('/invoices/store', 'BeforeStore')->name('before.store.invoice');
        Route::put('/Update/GetDebt/Invoice/{getDebt}'  ,'getDebtUpdate')->name('Update.GetDebt.Invoice');
        Route::post('/form/customer/invoice', 'FormCustomerStore')->name('form.customer.store');
        Route::get('list/invoice/all' , 'ListInvoiceAll')->name('list.invoice.all');
        Route::get('list/invoice' , 'ListInvoice')->name('list.invoice');
        Route::put('/repair/inv', 'repairAll')->name('repair.all');
        Route::delete('/delete/getdebts/invoice/{getDebt}' , 'DestroyFromInvoice')->name('delete.inv.getdebt');
    });
    Route::controller(GetDebtsController::class)->group(function () {
        Route::post('/customers/getdebt/{customer}',  'StoreFromCustomer')->name('customers.getdebt.store');
        Route::put('/repair/getdebts/{customer}', 'repairDebts')->name('repair.getdebts');
        Route::put('Update/Delivery/{getdebt}' ,  'UpdateDelivery')->name('update.delivery');
    });
    Route::controller(PrintsController::class)->group(function () {
        Route::get('category/{category}/product','ProductShow')->name('product.show');
        Route::get('Print/Invoice/{getdebt}','PrintInvoice')->name('print.invoice');
        Route::get('Print/Invoice/IQD/{getdebt}','PrintInvoiceIQD')->name('print.invoice.IQD');
        Route::get('Download/Invoice/{getdebt}','PrintInvoiceDownload')->name('download.invoice');
        Route::get('Download/Invoice/IQD/{getdebt}','PrintInvoiceIQDDownload')->name('download.invoice.IQD');
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile','update')->name('profile.update');
        Route::delete('/profile','destroy')->name('profile.destroy');
    });

    Route::controller(InvoiceBuysController::class)->group(function () {
        Route::put('/Update/RepDebt/InvoiceBuy/{repDebt}'  ,'repDebtUpdate')->name('Update.RepDebt.InvoiceBuy');
    });


    Route::get('Before/Create/InvoiceBuy' , [InvoiceBuysController::class , 'BeforeCreate'])->name('before.create.invoicebuy');
    Route::post('Before/Store/InvoiceBuy' , [InvoiceBuysController::class , 'BeforeStore'])->name('before.store.invoicebuy');
    Route::get('list/invoice/All/{customer}' , [CustomersController::class , 'ShowInvoiceCustomer'])->name('list.invoice.customer');
    Route::put('/products/{product}' , [ProductsController::class , 'FixNumber'])->name('fix.product');
    Route::put('/form/update/currency/{currency}', CurrenciesController::class)->name('update.currency');
    Route::put('/repair/offdebts/{office}',[OffDebtsController::class , 'repairDebts'])->name('repair.offdebts');
    Route::put('/repair/onlydebts/{debtor}',[OnlyDebtsController::class , 'repairDebts'])->name('repair.onlydebts');
});
require __DIR__.'/auth.php';
