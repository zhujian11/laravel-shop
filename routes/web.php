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

// 用户一进来就能看到商品列表，因此让首页直接跳转到商品页面
Route::redirect('/', '/products')->name('root');

// 注册与登录
Auth::routes(['verify' => true]);

// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function() {
    // 收货地址列表
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    // 新建收货地址
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
    // 修改收货地址
    Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
    Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
    // 删除收货地址
    Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    // 收藏与取消收藏商品
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    // 收藏列表
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
    // 添加购物车
    Route::post('cart', 'CartController@add')->name('cart.add');
    // 查看购物车
    Route::get('cart', 'CartController@index')->name('cart.index');
    // 移除购物车中商品
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    // 创建订单
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    // 订单列表
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    // 订单详情
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    // 支付宝支付
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    // 支付宝前端回调
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
    // 确认收货
    Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');
    // 展示评价
    Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
    // 提交评价
    Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');
    // 申请退款
    Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')->name('orders.apply_refund');
    // 检查优惠券
    Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');
    // 众筹商品下单
    Route::post('crowdfunding_orders', 'OrdersController@crowdfunding')->name('crowdfunding_orders.store');
    // 创建分期付款
    Route::post('payment/{order}/installment', 'PaymentController@payByInstallment')->name('payment.installment');
    // 分期付款列表
    Route::get('installments', 'InstallmentsController@index')->name('installments.index');
    // 分期详情
    Route::get('installments/{installment}', 'InstallmentsController@show')->name('installments.show');
    // 分期付款支付宝支付
    Route::get('installments/{installment}/alipay', 'InstallmentsController@payByAlipay')->name('installments.alipay');
    // 分期付款支付宝支付前端回调
    Route::get('installments/alipay/return', 'InstallmentsController@alipayReturn')->name('installments.alipay.return');
    // 秒杀
    Route::post('seckill_orders', 'OrdersController@seckill')->name('seckill_orders.store');
});

// 商品列表
Route::get('products', 'ProductsController@index')->name('products.index');
// 商品详情
Route::get('products/{product}', 'ProductsController@show')->name('products.show')->where(['product' => '[0-9]+']);
// 支付宝服务器端回调
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
// 分期付款支付宝支付后端回调
Route::post('installments/alipay/notify', 'InstallmentsController@alipayNotify')->name('installments.alipay.notify');
