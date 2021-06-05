<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});



Auth::routes();

Auth::routes(['register' => false]);
Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);



Route::group(['middleware' => ['auth']], function () {

		Route::get('/home','HomeController@index');

		Route::get('/main','sales@moneysafe');

		Route::get('/add-merchants','merchants@create');
		Route::get('/show-merchants','merchants@index');
		Route::post('create-merchant','merchants@store');
		Route::get('datatable-merchants','merchants@datatableMerchants');
		Route::get('merchant-delete/{id}','merchants@destroy');
		Route::post('delete-select-merchant','merchants@deleteSelected');
		Route::get('merchant-edite/{id}','merchants@edit');
		Route::post('update-merchant/{id}','merchants@update');
		Route::get('delete-merchants','merchants@truncated');
		Route::get('single-merchant/{id}','merchants@show');
		Route::get('delete-merchant-orders/{id}','merchants@deleteMerchantOrders');
		Route::post('merchant/add-postponed/{id}','merchants@addPostponedmerchants');
		Route::post('add-check-for-merchant/{id}','merchants@add_check_for_merchant');


		Route::get('/add-category','categories@create');
		Route::get('/show-categories','categories@index');
		Route::post('create-category','categories@store');
		Route::get('datatable-categories','categories@datatableCategories');
		Route::get('category-delete/{id}','categories@destroy');
		Route::post('delete-select-category','categories@deleteSelected');
		Route::get('category-edite/{id}','categories@edit');
		Route::post('update-category/{id}','categories@update');
		Route::get('delete-category','categories@truncated');



		Route::get('/add-orders-clothes','orderClothesController@create');
		Route::get('/show-orders-clothes','orderClothesController@index');
		Route::post('create-order-clothes','orderClothesController@store');
		Route::get('datatable-order-clothes','orderClothesController@datatableorderClothes');
		Route::get('order-clothes-delete/{id}/{type_return?}','orderClothesController@destroy');
		Route::post('delete-select-order-clothes','orderClothesController@deleteSelected');
		Route::get('order-clothes-edite/{id}','orderClothesController@edit');
		Route::post('update-order-clothes/{id}','orderClothesController@update');
		Route::get('delete-order-clothes','orderClothesController@truncated');
		Route::get('single-order-clothes/{id}','orderClothesController@show');
		Route::post('add-order-postponed/{id}','orderClothesController@add_order_postponed');



		Route::get('/add-clients','clientsController@create');
		Route::get('/show-clients','clientsController@index');
		Route::post('create-client','clientsController@store');
		Route::get('datatable-clients','clientsController@datatableClients');
		Route::get('client-delete/{id}','clientsController@destroy');
		Route::post('delete-select-client','clientsController@deleteSelected');
		Route::get('client-edite/{id}','clientsController@edit');
		Route::post('update-client/{id}','clientsController@update');
		Route::get('delete-clients','clientsController@truncated');
		Route::get('single-client/{id}','clientsController@show');
		Route::post('client/add-postponed/{id}','clientsController@addPostponedclients');
		Route::post('add-check-for-client/{id}','clientsController@add_check_for_client');


		Route::get('/index-clothes','ClothStylesController@indexClothes');
		Route::get('/add-piecies/{id}','ClothStylesController@create');
		Route::get('/show-piecies','ClothStylesController@index');
		Route::get('datatable-order-clothes-styles','ClothStylesController@datatableClothes');
		Route::post('create-piecies','ClothStylesController@store');
		Route::get('datatable-piecies','ClothStylesController@datatablePiecies');
		Route::get('piecies-delete/{id}','ClothStylesController@destroy');
		Route::post('delete-select-piecies','ClothStylesController@deleteSelected');
		Route::get('piecies-edite/{id}/{order_clothes_id}','ClothStylesController@edit');
		Route::post('update-piecies/{id}','ClothStylesController@update');
		Route::get('delete-piecies','ClothStylesController@truncated');
		Route::get('single-piecies/{id}','ClothStylesController@show');




		Route::get('/add-orders','ordersControllers@create');
		Route::get('/show-orders','ordersControllers@index');
		Route::post('/create-order','ordersControllers@store');
		Route::get('datatable-orders','ordersControllers@datatableOrders');
		Route::get('order-delete/{id}/{type_return?}','ordersControllers@destroy');
		Route::post('delete-select-order','ordersControllers@deleteSelected');
		Route::get('order-edite/{id}','ordersControllers@edit');
		Route::post('update-order/{id}','ordersControllers@update');
		Route::get('delete-order','ordersControllers@truncated');
		Route::get('single-order/{id}','ordersControllers@show');
		Route::get('/review-order/{id}','ordersControllers@review_order');
		Route::post('add-orders-sale-postponed/{id}','ordersControllers@add_orders_sale_postponed');



		Route::get('/add-products','productsController@create');
		Route::get('/show-products','productsController@index');
		Route::post('/create-product','productsController@store');
		Route::get('datatable-product','productsController@datatableProducts');
		Route::post('delete-select-product','productsController@deleteSelected');
		Route::get('product-delete/{id}/{type_return?}','productsController@destroy');
		Route::get('product-edite/{id}','productsController@edit');
		Route::post('update-product/{id}','productsController@update');
		Route::get('delete-product','productsController@truncated');
		Route::get('single-product/{id}','productsController@show');



		Route::get('/add-partner','PartnerPercentages@create');
		Route::get('/show-partners','PartnerPercentages@index');
		Route::post('create-partner','PartnerPercentages@store');
		Route::get('datatable-partners','PartnerPercentages@datatablePartners');
		Route::get('partner-delete/{id}','PartnerPercentages@destroy');
		Route::post('delete-select-partner','PartnerPercentages@deleteSelected');
		Route::get('partner-edite/{id}','PartnerPercentages@edit');
		Route::post('update-partner/{id}','PartnerPercentages@update');
		Route::get('delete-partners','PartnerPercentages@truncated');
		Route::get('single-partner/{id}','PartnerPercentages@show');



		Route::get('/add-reactionist/{order_id?}','reactionistController@create');
		Route::get('/add-reactionist-orders','reactionistController@orders');
		Route::get('datatable-reactionist-orders','reactionistController@datatableReactionistOrders');
		Route::get('/show-reactionist','reactionistController@index');
		Route::post('/create-reactionist/{id}','reactionistController@store');
		Route::get('datatable-reactionist','reactionistController@datatableReactionist');
		Route::get('reactionist-delete/{id}/{type_return?}','reactionistController@destroy');
		Route::post('delete-select-reactionist','reactionistController@deleteSelected');
		Route::get('reactionist-edite/{id}','reactionistController@edit');
		Route::post('update-reactionist/{id}/{order_id}','reactionistController@update');
		Route::get('delete-reactionist','reactionistController@truncated');
		Route::get('single-reactionist/{id}','reactionistController@show');





		Route::get('/withdraw-capital','withdrawController@index');
		Route::post('/create-withdraw','withdrawController@store');
		Route::get('datatable-withdraws','withdrawController@datatableWithdraws');
		Route::get('withdraw-delete/{id}','withdrawController@destroy');
		Route::post('delete-select-withdraw','withdrawController@deleteSelected');
		Route::get('withdraw-edite/{id}','withdrawController@edit');
		Route::post('update-withdraw/{id}','withdrawController@update');
		Route::get('delete-withdraw','withdrawController@truncated');
		Route::get('withdraw-client-delete/{id}','withdrawController@deleteWithdrawPartner');
		Route::post('withdraw-profit-and-end-partner/{id}','withdrawController@withdrawprofitandendpartner');


		//ajax
		Route::get('ajax-delete-Bankcheck/{id?}','bankCheckController@destroy');

		//ajax 
		Route::get('ajax-delete-postponed/{id?}','PostponedController@destroy');



		Route::get('inventory','inventory@index');
		Route::get('inventory/products/{product_type}','inventory@product');
		Route::get('datatable-product/{product_type}','inventory@datatableProducts');


		Route::get('inventory/order-clothes/{order_type}','inventory@orderClothes');
		Route::get('datatable-order-clothes/{order_type}','inventory@datatableorderClothes');


		Route::get('inventory/clothesStyles/{cloth_type}','inventory@clothesStyles');
		Route::get('datatable-clothes-styles','inventory@datatablePiecies');



		Route::get('inventory/category/{category_type}','inventory@category');
		Route::get('datatable-category','inventory@datatableCategories');



		Route::get('inventory/reactionist/{reactionist_type}','inventory@reactionist');
		Route::get('datatable-reactionist','inventory@datatableReactionist');


		Route::get('sales','sales@index');
		Route::get('get-report-sales','sales@get_report_sales');
		Route::get('datatable-sales','sales@datatablesales');


		Route::get('bank-check-clothes','bankCheckController@bank_check_clothes');
		Route::get('bank-check-orders','bankCheckController@bank_check_orders');

		Route::get('datatable-check-clothes','bankCheckController@datatablecheckclothes');
		Route::get('datatable-check-orders','bankCheckController@datatablecheckorders');

		Route::get('approve-check/{id}','bankCheckController@update');


		Route::get('factory-capital','withdrawController@factoryCapital');
		Route::post('create-capital','withdrawController@CreateCapital');
		Route::post('create-withdraw-capital','withdrawController@CreateWithdrawCapital');

		Route::post('withdraw-profit-only/{id}','withdrawController@CreateWithdrawProfite');

		Route::post('start-Fiscal-year','withdrawController@startFiscalyear');



		Route::get('/add-suppliers','suppliersController@create');
		Route::get('/show-suppliers','suppliersController@index');
		Route::post('create-suppliers','suppliersController@store');
		Route::get('datatable-suppliers','suppliersController@datatableSuppliers');
		Route::get('supplier-delete/{id}','suppliersController@destroy');
		Route::post('delete-select-supplier','suppliersController@deleteSelected');
		Route::get('supplier-edite/{id}','suppliersController@edit');
		Route::post('update-supplier/{id}','suppliersController@update');
		Route::get('delete-suppliers','suppliersController@truncated');
		Route::get('single-supplier/{id}','suppliersController@show');
		Route::get('delete-supplier-orders/{id}','suppliersController@deleteMerchantOrders');
		Route::post('supplier/add-postponed/{id}','suppliersController@addPostponedsuppliers');




		Route::get('/show-credit','debitController@credit');
		Route::get('/show-debit','debitController@debit');
		Route::get('/add-credit-debit','debitController@create');
		Route::post('create-debit','debitController@store');

		Route::get('datatable-credit','debitController@datatableCredit');
		Route::get('datatable-debit','debitController@datatabledebit');


		Route::post('pay-debit','debitController@Paydebit');

		Route::get('debit-delete/{id}','debitController@destroy');
		Route::post('delete-select-debit','debitController@deleteSelected');
		Route::get('debit-edite/{id}','debitController@edit');
		Route::post('update-debit/{id}','debitController@update');
		Route::get('delete-debits/{debit_type}','debitController@truncated');
		Route::get('single-debit/{id}','debitController@show');


		Route::get('add-Expances','sales@expances');
		Route::get('datatable-expances','sales@datatableExpances');
		Route::post('create-expances','sales@store');
		Route::get('delete-expances/{id}','sales@destroy');
		Route::get('delete-expances','sales@truncated');
		Route::post('delete-select-expances','sales@deleteSelected');


		Route::get('money-safe','sales@moneysafe');
});

