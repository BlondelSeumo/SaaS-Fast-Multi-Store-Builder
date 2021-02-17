<?php

use Illuminate\Support\Facades\Schema;
use App\Model\Domains;
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

Route::group(['middleware' => ['UserDomain']], function(){

Route::get('/', 'IndexController@index')->name('home');
Route::get('/cart', 'Dashboard\DashboardController@carting');

//Installer Routes
Route::group(['prefix' => 'install'], function(){
	Route::get('/', 'InstallController@install')->name('install');

	Route::get('app', 'InstallController@appDetail')->name('InstallApp');

	Route::post('app', 'InstallController@appDetailSubmit')->name('InstallApp');

	Route::get('database', 'InstallController@migration')->name('InstallDatabase');

	Route::get('final', 'InstallController@final')->name('InstallFinal');
});

Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => ['guest']], function(){

	# Auth Login
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

	Route::post('login', 'Auth\LoginController@login')->name('login');

	Route::get('reset-password', 'Auth\ResetPasswordController@showResetForm')->name('resetpassword');

	Route::post('reset-password', 'Auth\ResetPasswordController@validatePasswordRequest')->name('resetpassword');
	
	Route::post('reset_password_with_token', 'Auth\ResetPasswordController@resetPassword')->name('reset.password');

	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

	Route::post('register', 'Auth\RegisterController@register')->name('register');
	Route::get('auth/facebook', 'Auth\SocialloginCrontroller@redirectToFacebook')->name('user-auth-facebook');

	Route::get('auth/facebook/callback', 'Auth\SocialloginCrontroller@handleFacebookCallback');

	Route::get('auth/google', 'Auth\SocialloginCrontroller@redirectToGoogle')->name('user-auth-google');

    Route::get('auth/google/callback', 'Auth\SocialloginCrontroller@handleGoogleCallback');
});

# Resend token
Route::get('resend-activation', 'Auth\ResendTokenController@resendemailtoken')->name('resend-token');

Route::post('resend-activation', 'Auth\ResendTokenController@resendemailtoken_send')->name('resend-token');

# Pages and category
Route::get('pages', 'IndexController@pages')->name('all-pages');

Route::get('pages/{slug}', 'IndexController@innerpages');

Route::get('page/{page}', 'IndexController@page');
    
// Pricing
Route::get('pricing', 'IndexController@pricing')->name('pricing');

Route::post('pricing-bank/{package}/{duration}', 'PaymentController@postBankTransfer')->name('user-pricing-bank');

// Faq
Route::get('faq', 'Dashboard\DashboardController@faq')->name('user-faq');

Route::post('contact', 'IndexController@contact')->name('contact-us');

// Activate user
Route::get('activate/u/{token}','GeneralController@activate_email');

});
// Auth Group

Route::group(['middleware' => ['auth'], 'prefix' => 'dashboard'], function(){
		Route::group(['prefix' => 'pay'], function () {
			Route::group(['prefix' => 'init'], function () {
				Route::get('stripe/{plan}/{duration}', 'Payment\StripeController@create')->name('stripe-create');

				Route::get('paypal/{plan}/{duration}', 'Payment\PaypalController@create')->name('paypal-create');

				Route::get('midtrans/{plan}/{duration}', 'Payment\MidTransController@create')->name('midtrans-create');

				Route::get('paystack/{plan}/{duration}', 'Payment\PaystackController@create')->name('paystack-create');

				Route::get('razorPay/{plan}/{duration}', 'Payment\RazorPayController@create')->name('razor-create');

				Route::get('bank/{plan}/{duration}', 'Payment\BankController@create')->name('bank-create');

    			Route::get('mercadopago/{plan}/{duration}', 'Payment\MercadopagoController@create')->name('mercadopago-create');

			});
			Route::group(['prefix' => 'verify'], function () {
				Route::get('stripe/{plan}/{duration}', 'Payment\StripeController@verify')->name('stripe-verify');

				Route::get('paypal/{plan}/{duration}', 'Payment\PaypalController@verify')->name('paypal-verify');
				
				Route::get('midtrans/{plan}/{duration}', 'Payment\MidTransController@verify')->name('midtrans-verify');
				
				Route::get('razorPay/{plan}/{duration}', 'Payment\RazorPayController@verify')->name('razor-verify');

				Route::get('paystack/{plan}/{duration}', 'Payment\PaystackController@verify')->name('paystack-verify');

    			Route::get('mercadopago/{plan}/{duration}', 'Payment\MercadopagoController@verify')->name('mercadopago-verify');
			});
			Route::post('bank/{plan}/{duration}', 'Payment\BankController@post')->name('bank-post');
			Route::post('bank-delete/{id}', 'Payment\BankController@delete')->name('bank-delete');
		});


	Route::group(['middleware' => 'PackageStatus', 'namespace' => 'Dashboard'], function () {
		Route::get('/', 'DashboardController@dashboard')->name('user-dashboard');

		Route::post('back-to-free', 'DashboardController@back_to_free')->name('user-back-to-free');
			// Manage Profile

			Route::get('settings/delete-banner', 'DashboardController@delete_banner')->name('delete-banner');

			// Login Activity

			Route::get('login-activity', 'DashboardController@login_activity')->name('user-activities');

			Route::post('login-activity', 'DashboardController@deleteActivities')->name('user-activities');

			// Saats
			Route::get('stats', 'DashboardController@user_stats')->name('stats');
			
			# Settings
			Route::get('settings', 'DashboardController@settings')->name('user-settings');

			Route::post('settings', 'DashboardController@postSettings')->name('user-settings');

			Route::get('domains', 'DashboardController@domains')->name('user-domains');

			Route::get('domains/post', 'DashboardController@domains_post_get')->name('user-domains-post');

			Route::post('domains/post', 'DashboardController@domains_post')->name('user-domains-post');
		});


	// Dashboard Products 
	Route::group(['namespace' => 'Dashboard'], function(){
			Route::get('transactions-history', 'DashboardController@transactions_history')->name('user-transactions');

			Route::get('invoice/{plan}', 'PaymentController@payment_invoice')->name('user-invoice');

			Route::get('plan/{plan}', 'PaymentController@payment_select')->name('user-package-select');

			Route::get('payment-callback/{plan}/{gateway}', 'PaymentController@callback')->name('paymentcallback');
			// Dashboard Post Category
			Route::get('products/category', 'ProductController@category_view')->name('user-product-category');
			Route::post('products/category/{type}', 'ProductController@category_post')->name('user-product-post-category');

			// Product Orders
			Route::get('products/orders', 'ProductController@orders')->name('user-orders');
			Route::post('orders', 'ProductController@order_status')->name('user-order-status');
			Route::get('products/orders/{id}', 'ProductController@single_orders')->name('user-single-order');

			# Products
			Route::get('products/add-product', 'ProductController@new_product')->name('user-add-product');
			Route::get('products', 'ProductController@my_product')->name('user-products');
			Route::post('remove-option-value', 'ProductController@remove_option_value')->name('user-remove-product-option-value');
			Route::post('remove-option', 'ProductController@remove_option')->name('user-remove-product-option');

			Route::post('products/sortable', 'ProductController@products_sortable')->name('user-products-sortable');

			Route::post('products-img/sortable/{id}', 'ProductController@products_sortable_images')->name('user-products-sortable-images');

			Route::post('products/{type}', 'ProductController@post_product')->name('user-post-product');


			Route::get('products/edit-product/{id}', 'ProductController@edit_product')->name('user-edit-product');

			// Blog
			Route::get('blog', 'DashboardController@blog')->name('user-blog');

			Route::post('blog', 'DashboardController@post_blog')->name('user-blog');

			Route::post('blog-sort', 'DashboardController@blog_sortable')->name('user-blog-sortable');

			Route::get('blog/{id}/delete', 'DashboardController@blog_delete')->name('user-blog-delete');

			# Shipping

			Route::get('shipping', 'DashboardController@shipping')->name('user-shipping');
			Route::get('shipping/add', 'DashboardController@add_shipping')->name('user-add-shipping');
			Route::get('shipping/edit/{slug}', 'DashboardController@edit_shipping')->name('user-edit-shipping');
			Route::post('shipping/post/{type}', 'DashboardController@post_shipping')->name('user-shipping-post');

		});

		Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
			Route::get('/', 'AdminController@home_admin')->name('admin-home');

			Route::get('domains', 'AdminController@domains')->name('admin-domains');

			Route::get('domains/post', 'AdminController@domains_post_get')->name('admin-domains-post');

			Route::post('domains/post', 'AdminController@domains_post')->name('admin-domains-post');

			Route::get('admin-trans', 'AdminController@admin_trans')->name('admin-translation');

			Route::post('admin-trans/{type}', 'AdminController@admin_post_trans')->name('admin-translation-post');

			Route::post('login-user', 'LoginAsController@admin_login_as_user')->name('admin-login-user');

			Route::get('create-user', 'AdminController@admin_create_user')->name('admin-create-user');

			Route::post('create-user', 'AdminController@admin_create_user_post')->name('admin-create-post-user');

			Route::get('update-migrate', 'AdminController@updateMigrate')->name('admin-update-migrate');

			Route::get('update-cloud', 'AdminController@runUpdateOnline')->name('admin-update-cloud');

			Route::post('update-check', 'AdminController@checkForUpdate')->name('admin-update-check');

			Route::post('update-cloud-license-code', 'AdminController@update_license_code')->name('admin-update-license-code');

			// Users
			Route::get('users', 'AdminController@users')->name('admin-users');

			Route::post('user/send', 'AdminController@send_usermail')->name('send.user.mail');

			Route::post('user/delete', 'AdminController@delete_user')->name('delete.user');

			Route::get('users/{id}/delete-banner', 'AdminController@delete_userbanner');


			// Stats
			Route::get('stats', 'AdminController@stats')->name('admin-stats');

			// Products

			Route::get('products', 'AdminController@all_product')->name('admin-all-products');
			Route::get('products/edit-product/{id}', 'AdminController@edit_product')->name('admin-edit-product');


			// Pages
			Route::get('pages', 'AdminController@pages')->name('pages');

			Route::get('pages/add', 'AdminController@add_pages')->name('add.pages');

			Route::post('pages/add', 'AdminController@post_page')->name('post.page');

			Route::get('pages/{id}', 'AdminController@edit_pages');

			Route::post('pages/edit', 'AdminController@edit_post_page')->name('edit.post.page');

			Route::post('pages/delete', 'AdminController@delete_page')->name('delete-admin-page');


			// Pages category
			Route::get('pages-category', 'AdminController@category')->name('category');

			Route::get('pages-category/add', 'AdminController@add_category')->name('add.category');

			Route::post('pages-category/add', 'AdminController@post_category')->name('post.category');

			Route::get('pages-category/{id}', 'AdminController@edit_category');

			Route::post('pages-category/edit', 'AdminController@edit_post_category')->name('edit.post.category');

			Route::post('pages-category/delete', 'AdminController@delete_category')->name('delete-admin-category');


			// Faq
			Route::get('faq', 'AdminController@faq')->name('faq');

			Route::post('faq', 'AdminController@post_faq')->name('post.faq');

			Route::post('edit-faq', 'AdminController@edit_faq')->name('edit.faq');

			Route::post('faq/delete', 'AdminController@delete_faq')->name('delete-admin-faq');


			// Payments
			Route::get('payments', 'AdminController@payments')->name('payments');
			Route::get('pending-payments', 'AdminController@pending_payments')->name('admin-pendiing-payments');

			Route::get('pending-payments/{type}/{id}', 'AdminController@activate_pending_payment')->name('admin-activate-pendiing-payments');


			// Package
			Route::get('packages', 'AdminController@packages')->name('admin-packages');

			Route::get('packages/create', 'AdminController@create_packages')->name('admin-add-package');

			Route::post('packages/create', 'AdminController@post_packages')->name('post.package');

			Route::post('packages/edit/{id}', 'AdminController@edit_post_package')->name('edit.post.package');

			Route::get('packages/edit/{id}', 'AdminController@edit_package');

			Route::post('packages/{id}/{type}', 'AdminController@PostPackagePrices')->name('admin-packagePrices');

			Route::get('packages/{id}', 'AdminController@DeletePackagePrice')->name('admin-deletepackageprice');

			Route::post('packages/delete', 'AdminController@delete_package')->name('admin-delete-package');


			// Settings
			Route::get('settings', 'AdminController@settings')->name('admin-settings');

			Route::post('settings', 'AdminController@post_settings')->name('post.settings');


			Route::get('updates', 'AdminController@adminUpdates')->name('admin-updates');

			Route::post('updates', 'AdminController@adminPostUpdates')->name('admin-updates');
		});
});

Route::get('t/{slug}', 'RedirectController@linkerRedirect')->name('linker');
Route::post('addFavorite', 'ProductController@addFavorite')->name('product.addFavorite.post');

$domain = '{profile}';
if (file_exists(storage_path('installed')) && Schema::hasTable('domains') && isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
  foreach (Domains::get() as $value) {
     if ($host == $value->host && $value->user !== null) {
        $domain = '';        
     }
  }
}
Route::group(['prefix' => 'cart'], function () {
	Route::post('{user_id}/{product}', '\App\Cart@add')->name('add-to-cart');
	Route::post('remove/{user}/{id}', '\App\Cart@remove')->name('remove-from-cart');

	Route::post('product-price', 'Dashboard\ProductController@product_price')->name('user-get-product-prices');

	Route::post('update/{user}/{id}', '\App\Cart@update')->name('update-cart');
});

Route::group(['prefix' => $domain, 'namespace' => 'Profile', 'middleware' => 'RemoveParmsFromDomain'], function () {
	Route::get('/', 'ProfileController@index')->name('user-profile');

	Route::get('about', 'ProfileController@about')->name('user-profile-about');

	Route::get('blog', 'ProfileController@blogs')->name('user-profile-blog');

	Route::get('blog/{id}', 'ProfileController@single_blogs')->name('user-profile-single-blog');

	Route::get('products', 'ProfileController@products')->name('user-profile-products');

	Route::get('categories', 'ProfileController@categories')->name('user-profile-categories');

	Route::get('product/{id}', 'ProfileController@single_product')->name('user-profile-single-product');

	Route::post('product/{id}/reviews', 'ProfileController@postReviews')->name('user-profile-product-review-post');

	Route::get('product/{id}/reviews', 'ProfileController@reviews')->name('user-profile-product-review');

	Route::get('orders', 'ProfileController@orders')->name('user-profile-orders');

	Route::post('add-to-cart/{id}', 'ProfileController@add_to_cart')->name('user-add-to-cart');

	Route::get('checkout', 'ProfileController@checkout')->name('user-profile-checkout');

	Route::post('checkout', 'ProfileController@postcheckout')->name('user-profile-checkout');

	Route::get('success', 'ProfileController@success')->name('user-store-success');

    Route::group(['prefix' => 'pay'], function () {
    	Route::group(['prefix' => 'init'], function () {
    		Route::get('stripe', 'Payment\StripeController@create')->name('user-stripe-create');

    		Route::get('paypal', 'Payment\PaypalController@create')->name('user-paypal-create');

    		Route::get('midtrans', 'Payment\MidTransController@create')->name('user-midtrans-create');

    		Route::get('paystack', 'Payment\PaystackController@create')->name('user-paystack-create');

    		Route::get('razorPay', 'Payment\RazorPayController@create')->name('user-razor-create');

    		Route::get('bank', 'Payment\BankController@create')->name('user-bank-create');

    		Route::get('cash', 'Payment\CashController@create')->name('user-cash-create');

    		Route::get('mercadopago', 'Payment\MercadopagoController@create')->name('user-mercadopago-create');

    	});
    	Route::group(['prefix' => 'verify'], function () {
    		Route::get('stripe', 'Payment\StripeController@verify')->name('user-stripe-verify');

    		Route::get('paypal', 'Payment\PaypalController@verify')->name('user-paypal-verify');
    		
    		Route::get('midtrans', 'Payment\MidTransController@verify')->name('user-midtrans-verify');
    		
    		Route::get('razorPay', 'Payment\RazorPayController@verify')->name('user-razor-verify');

    		Route::get('paystack', 'Payment\PaystackController@verify')->name('user-paystack-verify');

    		Route::get('mercadopago', 'Payment\MercadopagoController@verify')->name('user-mercadopago-verify');
    	});
    	Route::post('bank', 'Payment\BankController@post')->name('user-bank-post');
    	Route::post('bank-delete/{id}', 'Payment\BankController@delete')->name('user-bank-delete');
    });
});
