<?php

use App\Http\Controllers\CMS\AuthAdminController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\ItemController;
use App\Http\Controllers\CMS\ListCustomerController;
use App\Http\Controllers\CMS\master_item\KategoriController;
use App\Http\Controllers\CMS\master_item\UkuranController;
use App\Http\Controllers\CMS\ReportController;
use App\Http\Controllers\CMS\TransactionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Toko\AlamatController;
use App\Http\Controllers\Toko\AuthUserController;
use App\Http\Controllers\Toko\Cart_WishlistController;
use App\Http\Controllers\Toko\CheckoutController;
use App\Http\Controllers\Toko\CustomerController;
use App\Http\Controllers\Toko\LandingpageController;
use App\Http\Controllers\Toko\RajaOngkirController;
use App\Models\Detail_penjualan;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

use function Ramsey\Uuid\v1;

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


Route::get('/tes', function () {

    $pembayaran =  Pembayaran::select(['penjualans.id', 'email', 'code_order', 'nota', 'total', 'tarif'])
        ->leftJoin('penjualans', 'pembayarans.id', '=', 'penjualans.pembayaran_id')
        ->leftJoin('users', 'penjualans.user_id', '=', 'users.id')
        ->join('kurirs', 'penjualans.kurir_id', '=', 'kurirs.id')
        ->where('code_order', '19182151')
        ->first();

    $detail_penjualans = Detail_penjualan::select([
        'detail_penjualans.id',
        'items.nama as nama',
        'ukurans.nama as ukuran',
        'qty'
    ])
        ->join('items', 'detail_penjualans.item_id', '=', 'items.id')
        ->join('ukurans', 'detail_penjualans.ukuran_id', '=', 'ukurans.id')
        ->where('penjualan_id', $pembayaran->id)->get();
    // return $data;

    return view('toko.layout.email.transaction_accepted', [
        'pembayaran' => $pembayaran,
        'detail_penjualan' => $detail_penjualans
    ]);
});

// // verify email
Route::middleware(['auth:web'])->group(function () {
    Route::get('/email/verify', [AuthUserController::class, 'verification_notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthUserController::class, 'verification_handler'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthUserController::class, 'resend_verification'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::post('/customer/account/logout', [AuthUserController::class, 'logout']);
});

// user
Route::middleware(['guest:web', 'preventBack'])->group(function () {
    Route::get('/customer/account/create', [AuthUserController::class, 'register']);
    Route::post('/customer/account/store', [AuthUserController::class, 'store_account']);
    Route::post('/customer/account/authenticate', [AuthUserController::class, 'authenticate']);
    Route::get('/customer/account/login', [AuthUserController::class, 'register_or_login']);

    Route::get('/customer/account/forgotpassword', [AuthUserController::class, 'forgot_password'])->name('password.request');
    Route::post('/customer/account/forgotpassword', [AuthUserController::class, 'send_forgot_password_email'])->name('password.email');
    Route::get('/customer/account/reset-password/{token}', [AuthUserController::class, 'reset_password'])->name('password.reset');
    Route::post('/customer/account/reset-password', [AuthUserController::class, 'update_password'])->name('password.update');
});

Route::middleware(['auth:web', 'verified', 'preventBack'])->group(function () {
    Route::get('/customer/account', [CustomerController::class, 'account']);
    Route::get('/customer/order-history', [CustomerController::class, 'pesanan']);
    Route::get('/customer/order-history/{id}/detail-pesanan', [CustomerController::class, 'lihat_detail_pesanan']);
    Route::post('/customer/oerder-history/{id}/pesan_ulang', [CustomerController::class, 'pesan_ulang']);
    Route::get('/customer/wish-list', [CustomerController::class, 'wish_list']);
    Route::get('/customer/address', [CustomerController::class, 'address']);
    Route::get('/customer/address/create', [CustomerController::class, 'create_address']);
    Route::delete('/customer/address/{id}/delete', [AlamatController::class, 'delete']);
    Route::get('/customer/address/{id}/edit', [AlamatController::class, 'edit']);
    Route::put('/customer/address/{id}/update', [AlamatController::class, 'update']);

    Route::get('/customer/account/edit', [CustomerController::class, 'informasi_account']);
    Route::post('/customer/account/update', [AuthUserController::class, 'update_account']);

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

Route::get('/', [LandingpageController::class, 'landing_page'])->name('user.login');
Route::get('/list-item', [LandingpageController::class, 'list_item'])->name('list_item');
Route::post('/list-item-ajax', [LandingpageController::class, 'ajax_list_items']);
Route::get('/list-item/{id}/detail-item', [LandingpageController::class, 'detail_item']);
Route::post('/list-item/detail-item-stok-ajax', [LandingpageController::class, 'detail_item_stok_ajax']);

// admin

Route::middleware(['guest:webadmin', 'preventBack'])->group(function () {
    Route::get('/admin/auth/dashboard/login', [AuthAdminController::class, 'login'])->name('admin.login');
    Route::post('/admin/auth/dashboard/authenticate', [AuthAdminController::class, 'authenticate']);
});

Route::middleware(['auth:webadmin'])->group(function () {
    Route::post('/admin/auth/dashboard/logout', [AuthAdminController::class, 'logout']);
    // Route::resource('/admin/auth', AuthAdminController::class);

    // dashboard master
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/master-item/kategori', KategoriController::class);
    Route::resource('/admin/master-item/ukuran', UkuranController::class);

    // item
    Route::resource('/admin/item', ItemController::class);
    Route::get('/admin/item/{id}/tambah-stok', [ItemController::class, 'tambah_stok_item']);
    Route::post('/admin/item/{id}/store-stok-item', [ItemController::class, 'store_stok_item']);
    Route::post('/admin/item/{id}/store-list-item', [ItemController::class, 'store_list_item']);
    Route::delete('/admin/item/{item}/{id}/hapus_list_ukuran', [ItemController::class, 'detroy_list_ukuran']);

    //list customer
    Route::get('/admin/list-customer', [ListCustomerController::class, 'index']);
    Route::get('/admin/list-customer/{id}', [ListCustomerController::class, 'show']);

    // transaction
    Route::get("/admin/list-transaction", [TransactionController::class, 'index']);
    Route::get("/admin/list-transaction/{id}/detail", [TransactionController::class, 'detail_pembelian']);
    Route::put('/admin/list-transaction/{id}/konfirmasi', [TransactionController::class, 'konfirmasi_pembelian']);

    Route::get('/admin/laporan/confirmed', [ReportController::class, 'confirmed']);
    Route::get('/admin/laporan/rejected', [ReportController::class, 'rejected']);
    Route::get('/admin/laporan/failed', [ReportController::class, 'failed']);

    // print pdf 
    Route::get('/customer/order-history/detail/{id}/print', [PdfController::class, 'print_pesanan_user']);
});
// demo
Route::get('demo-admin', [AuthAdminController::class, 'demo']);
Route::resource('/admin/auth', AuthAdminController::class);
