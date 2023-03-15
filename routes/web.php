<?php

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
//Front
Route::get('/','HomeController@index');

Route::get('/trang-chu','HomeController@index');
Route::post('/tim-kiem','HomeController@search');
Route::get('/lien-he','HomeController@contact');
Route::get('/chinh-sach','HomeController@polyci');



//Danh mục SP-trang chủ

Route::get('/danh-muc/{category_id}','CategoryProduct@Show_category_home');
Route::get('/thuong-hieu/{brand_id}','BrandProduct@Show_brand_home');
Route::get('/chi-tiet/{product_id}','ProductController@details_product');




//Back
Route::get('/admin','QLAdminController@index');
Route::get('/dashboard','QLAdminController@show_dashboard');
Route::get('/logout','QLAdminController@logout');
Route::post('/admin-dashboard','QLAdminController@dashboard');


//category
Route::get('/add-category-product','CategoryProduct@add_category_product');
Route::get('/all-category-product','CategoryProduct@all_category_product');
Route::get('/edit-category-product/{category_product_id}','CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','CategoryProduct@delete_category_product');



Route::get('/unactive-category-product/{category_product_id}','CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','CategoryProduct@active_category_product');

Route::post('/save-category-product','CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','CategoryProduct@update_category_product');



//Brand
Route::get('/add-brand-product','BrandProduct@add_brand_product');
Route::get('/all-brand-product','BrandProduct@all_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','BrandProduct@delete_brand_product');



Route::get('/unactive-brand-product/{brand_product_id}','BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','BrandProduct@active_brand_product');

Route::post('/save-brand-product','BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandProduct@update_brand_product');


//Product
Route::get('/add-product','ProductController@add_product');
Route::get('/all-product','ProductController@all_product');
Route::get('/edit-product/{product_id}','ProductController@edit_product');
Route::get('/delete-product/{product_id}','ProductController@delete_product');



Route::get('/unactive-product/{product_id}','ProductController@unactive_product');
Route::get('/active-product/{product_id}','ProductController@active_product');

Route::post('/save-product','ProductController@save_product');
Route::post('/update-product/{product_id}','ProductController@update_product');


//Cart
Route::post('/save-cart','CartController@save_cart');
Route::post('/add-cart-ajax','CartController@add_cart_ajax');
Route::post('/update-cart-quantity','CartController@update_cart_quantity');
Route::post('/update-cart','CartController@update_cart');

Route::get('/show-cart','CartController@show_cart');
Route::get('/gio-hang','CartController@gio_hang');
Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');
Route::get('/del-product/{session_id}','CartController@del_product');
Route::get('/del-all-product','CartController@del_all_product');


Route::post('/insert-rating','ProductController@insert_rating');
Route::post('/load-comment','ProductController@load_comment');
Route::post('/send-comment','ProductController@send_comment');
Route::get('/comment','ProductController@list_comment');
Route::post('/allow-comment','ProductController@allow_comment');
Route::post('/reply-comment','ProductController@reply_comment');

//checkout
Route::get('/login-checkout','CheckoutController@login_checkout');
Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::post('/add-customer','CheckoutController@add_customer');
Route::post('/order-place','CheckoutController@order_place');
Route::get('/delete-order/{order_code}','CheckoutController@delete_order');
Route::get('/delete-comment/{comment_id}','CheckoutController@delete_comment');
Route::post('/login-customer','CheckoutController@login_customer');
Route::get('/checkout','CheckoutController@checkout');
Route::post('/confirm-order','CheckoutController@confirm_order');
Route::get('/payment','CheckoutController@payment');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::post('/calculate-fee','CheckoutController@calculate_fee');
Route::get('/print-order/{checkout_code}','CheckoutController@print_order');
Route::post('/huy-don-hang','CheckoutController@huy_don_hang');
/// order hàng
Route::get('/manage-order','CheckoutController@manage_order');
Route::get('/view-order/{order_code}','CheckoutController@view_order');
Route::post('/update-qty','CheckoutController@update_qty');
Route::post('/update-order-qty','CheckoutController@update_order_qty');
Route::get('/view-history-order/{order_code}','CheckoutController@view_history_order');
Route::get('/history','CheckoutController@history');
//coupon
Route::post('/check-coupon','CartController@check_coupon');
Route::get('/insert-coupon','CouponController@insert_coupon');
Route::get('/list-coupon','CouponController@list_coupon');
Route::get('/unset-coupon','CouponController@unset_coupon');

Route::get('/delete-coupon/{coupon_id}','CouponController@delete_coupon');

Route::post('/insert-coupon-code','CouponController@insert_coupon_code');

//delivery
Route::get('/delivery','DeliveryController@delivery');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');
Route::post('/select-delivery-home','DeliveryController@select_delivery_home');


//Banner
Route::get('/manage-slider','SliderController@manage_slider');
Route::get('/add-slider','SliderController@add_slider');
Route::get('/delete-slide/{slide_id}','SliderController@delete_slide');
Route::post('/insert-slider','SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}','SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}','SliderController@active_slide');