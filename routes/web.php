<?php

use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\ItemController;
use App\Http\Controllers\CMS\ListCustomerController;
use App\Http\Controllers\CMS\master_item\KategoriController;
use App\Http\Controllers\CMS\master_item\UkuranController;
use App\Http\Controllers\CMS\TransactionController;
use App\Http\Controllers\Toko\AlamatController;
use App\Http\Controllers\Toko\AuthUserController;
use App\Http\Controllers\Toko\Cart_WishlistController;
use App\Http\Controllers\Toko\CheckoutController;
use App\Http\Controllers\Toko\CustomerController;
use App\Http\Controllers\Toko\LandingpageController;
use App\Http\Controllers\Toko\RajaOngkirController;
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

Route::get('/tes', function () {
    $json = [
        "status_code" => "201",
        "status_message" => "Success, Bank Transfer transaction is created",
        "transaction_id" => "be03df7d-2f97-4c8c-a53c-8959f1b67295",
        "order_id" => "1571823229",
        "merchant_id" => "G812785002",
        "gross_amount" => "44000.00",
        "currency" => "IDR",
        "payment_type" => "bank_transfer",
        "transaction_time" => "2019-10-23 16:33:49",
        "transaction_status" => "pending",
        "va_numbers" => [
            [
                "bank" => "bca",
                "va_number" => "812785002"
            ]
        ],
        "fraud_status" => "accept"
    ];

    // $json = [
    //     "status_code" => "201",
    //     "status_message" => "OK,
    //      Mandiri Bill transaction is successful",
    //     "transaction_id" => "abb2d93f-dae3-4183-936d-4145423ad72f",
    //     "order_id" => "1571823332",
    //     "merchant_id" => "G812785002",
    //     "gross_amount" => "44000.00",
    //     "currency" => "IDR",
    //     "payment_type" => "echannel",
    //     "transaction_time" => "2019-10-23 16:35:31",
    //     "transaction_status" => "pending",
    //     "fraud_status" => "accept",
    //     "bill_key" => "778347787706",
    //     "biller_code" => "70012"
    // ];

    return view('toko.layout.email.bill_email', [
        'data' => $json
    ]);
});

// user
Route::middleware(['guest'])->group(function () {
    Route::get('/customer/account/create', [AuthUserController::class, 'register']);
    Route::post('/customer/account/store', [AuthUserController::class, 'store_account']);
    Route::post('/customer/account/authenticate', [AuthUserController::class, 'authenticate']);
    Route::get('/customer/account/login', [AuthUserController::class, 'register_or_login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/customer/account/logout', [AuthUserController::class, 'logout']);
    Route::get('/customer/account', [CustomerController::class, 'account']);
    Route::get('/customer/order-history', [CustomerController::class, 'pesanan']);
    Route::get('/customer/wish-list', [CustomerController::class, 'wish_list']);
    Route::get('/customer/address', [CustomerController::class, 'address']);
    Route::get('/customer/account/edit', [CustomerController::class, 'informasi_account']);

    Route::post('/list-item/cart/{id}', [Cart_WishlistController::class, 'store_cart']);
    Route::delete('/list-item/cart/{id}/destroy', [Cart_WishlistController::class, 'destroy_cart']);
    Route::post('/list-item/wish_list/{id}', [Cart_WishlistController::class, 'store_wishlist']);
    Route::delete('/list-item/wish_list/{id}/destroy', [Cart_WishlistController::class, 'destroy_wish_list']);

    // checkout
    Route::get('/checkout/pengiriman', [CheckoutController::class, 'pengiriman']);
    Route::put('/checkout/pengiriman/{id_alamat}/set_alamat_primary', [CheckoutController::class, 'set_alamat_primary_customer']);
    Route::get('/checkout/alamat-pengiriman/province', [RajaOngkirController::class, 'get_province']);
    Route::get('/checkout/alamat-pengiriman/province/{id}/city', [RajaOngkirController::class, 'get_city']);
    Route::get('/checkout/alamat-pengiriman/province/{city_id}/city/{province_id}', [RajaOngkirController::class, 'get_postal_code']);
    Route::get('/checkout/alamat-pengiriman/{courier}/cost', [RajaOngkirController::class, 'get_cost']);
    Route::post('/checkout/store-session-from-ajax', [RajaOngkirController::class, 'retireve_sessoin_service']);

    Route::get('/checkout/cart', [CheckoutController::class, 'keranjang']);
    Route::put('/checkout/cart/{id}/ajax', [Cart_WishlistController::class, 'update_cart_ajax']);
    Route::get('/checkout/cart/{id}/edit-cart', [Cart_WishlistController::class, 'edit_cart']);

    // alaamt
    Route::post('/alamat', [AlamatController::class, 'store']);
    Route::get('/checkout/pembayaran', [CheckoutController::class, 'pembayaran']);
    Route::post('/checkout/pembayaran/pay', [CheckoutController::class, 'pay']);
});

Route::get('/', [LandingpageController::class, 'landing_page'])->name('login');
Route::get('/list-item', [LandingpageController::class, 'list_item']);
Route::post('/list-item-ajax', [LandingpageController::class, 'ajax_list_items']);
Route::get('/list-item/{id}/detail-item', [LandingpageController::class, 'detail_item']);




// admin
Route::get('/admin/dashboard', [DashboardController::class, 'index']);
Route::resource('/admin/master-item/kategori', KategoriController::class);
Route::resource('/admin/master-item/ukuran', UkuranController::class);

// item
Route::resource('/admin/item', ItemController::class);
Route::get('/admin/item/{id}/tambah-stok', [ItemController::class, 'tambah_stok_item']);
Route::post('/admin/item/{id}/store-stok-item', [ItemController::class, 'store_stok_item']);
Route::post('/admin/item/{id}/store-list-item', [ItemController::class, 'store_list_item']);

//list customer
Route::get('/admin/list-customer', [ListCustomerController::class, 'index']);
Route::get('/admin/list-customer/{id}', [ListCustomerController::class, 'show']);

// transaction
Route::get("/admin/list-transaction", [TransactionController::class, 'index']);
Route::get("/admin/list-transaction/{id}/detail", [TransactionController::class, 'detail_pembelian']);
