<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionCsvDataController;
use App\Http\Controllers\PaymentRequestController;
use App\Http\Controllers\ReportController;

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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::get('payment_request', [PaymentRequestController::class, 'index'])->name('payment_request');
Route::post('payment_request/store', [PaymentRequestController::class, 'store'])->name('payment_request.store');

Route::controller(AuthController::class)->middleware('loggedin')->group(function() {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
});

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(BankController::class)->group(function(){
        Route::get('banks', 'index')->name('banks');
        Route::get('banks/list', 'list')->name('banksList');
        Route::post('banks/store', 'store')->name('banksStore');
        Route::post('banks/show/{id}', 'show')->name('bankShow');
        Route::post('banks/update/{id}', 'update')->name('bankUpdate');
        Route::post('banks/update-status', 'update_status')->name('banksUpdateStatus');
        Route::delete('banks/delete/{id}', 'destroy')->name('banksDestory');
        Route::post('banks/restore/{id}', 'restore')->name('banksRestore');
    });

    Route::controller(MethodController::class)->group(function(){
        Route::get('methods', 'index')->name('methods');
        Route::post('methods/store', 'store')->name('method.store');
        Route::get('methods/list', 'list')->name('method.list');
        Route::post('methods/update-status', 'update_status')->name('bank.upddate.status');
        Route::post('methods/show', 'show')->name('method.show');
        Route::post('methods/update/{id}', 'update')->name('method.update');
        Route::delete('methods/delete/{id}', 'destroy')->name('method.delete');
        Route::post('methods/restore/{id}', 'restore')->name('method.restore');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('categories', 'index')->name('categories');
        Route::post('categories/store', 'store')->name('category.store');
        Route::get('categories/list/{type}', 'list')->name('category.list');
        Route::post('categories/options', 'get_trans_type_options')->name('category.options');
        Route::post('categories/update-status', 'update_status')->name('category.upddate.status');
        Route::post('categories/show', 'show')->name('category.show');
        Route::post('categories/update/{id}', 'update')->name('category.update');
        Route::delete('categories/delete/{id}', 'destroy')->name('category.delete');
        Route::post('categories/restore/{id}', 'restore')->name('category.restore');
    });

    Route::controller(TransactionController::class)->group(function(){
        Route::get('transactions', 'index')->name('transactions');
        Route::post('transactions/store', 'store')->name('transactions.store');
        Route::post('transactions/options', 'get_transaction_category_option_tree')->name('transactions.options');
        Route::get('transactions/list', 'list')->name('transactions.list');
        Route::post('transactions/edit', 'edit')->name('transactions.edit');
        Route::post('transactions/update', 'update')->name('transactions.update');
        Route::get('transactions/show/{id}', 'show')->name('transactions.show');

        Route::get('transactions/log-list', 'log_list')->name('transactions.log.list');
    });

    Route::controller(TransactionCsvDataController::class)->group(function(){
        Route::get('csv/{fileName?}', 'index')->name('csv');
        Route::post('csv/store', 'store')->name('csv.store');
        Route::post('csv/migration', 'migrate_csv')->name('csv.to.transaction');

        /*
        Route::post('transactions/options', 'get_transaction_category_option_tree')->name('transactions.options');
        
        Route::post('transactions/edit', 'edit')->name('transactions.edit');
        Route::post('transactions/update', 'update')->name('transactions.update');
        Route::get('transactions/show/{id}', 'show')->name('transactions.show');*/
    });

    Route::controller(ReportController::class)->group(function(){
        Route::get('report', 'index')->name('report');
        Route::post('report/list', 'list')->name('report.list');
    });
    

    Route::controller(PageController::class)->group(function() {
        Route::get('/', 'dashboardOverview1')->name('dashboard-overview-1');
        Route::get('dashboard-overview-2-page', 'dashboardOverview2')->name('dashboard-overview-2');
        Route::get('dashboard-overview-3-page', 'dashboardOverview3')->name('dashboard-overview-3');
        Route::get('dashboard-overview-4-page', 'dashboardOverview4')->name('dashboard-overview-4');
        Route::get('categories-page', 'categories')->name('categories01');
        Route::get('add-product-page', 'addProduct')->name('add-product');
        Route::get('product-list-page', 'productList')->name('product-list');
        Route::get('product-grid-page', 'productGrid')->name('product-grid');
        Route::get('transaction-list-page', 'transactionList')->name('transaction-list');
        Route::get('transaction-detail-page', 'transactionDetail')->name('transaction-detail');
        Route::get('seller-list-page', 'sellerList')->name('seller-list');
        Route::get('seller-detail-page', 'sellerDetail')->name('seller-detail');
        Route::get('reviews-page', 'reviews')->name('reviews');
        Route::get('inbox-page', 'inbox')->name('inbox');
        Route::get('file-manager-page', 'fileManager')->name('file-manager');
        Route::get('point-of-sale-page', 'pointOfSale')->name('point-of-sale');
        Route::get('chat-page', 'chat')->name('chat');
        Route::get('post-page', 'post')->name('post');
        Route::get('calendar-page', 'calendar')->name('calendar');
        Route::get('crud-data-list-page', 'crudDataList')->name('crud-data-list');
        Route::get('crud-form-page', 'crudForm')->name('crud-form');
        Route::get('users-layout-1-page', 'usersLayout1')->name('users-layout-1');
        Route::get('users-layout-2-page', 'usersLayout2')->name('users-layout-2');
        Route::get('users-layout-3-page', 'usersLayout3')->name('users-layout-3');
        Route::get('profile-overview-1-page', 'profileOverview1')->name('profile-overview-1');
        Route::get('profile-overview-2-page', 'profileOverview2')->name('profile-overview-2');
        Route::get('profile-overview-3-page', 'profileOverview3')->name('profile-overview-3');
        Route::get('wizard-layout-1-page', 'wizardLayout1')->name('wizard-layout-1');
        Route::get('wizard-layout-2-page', 'wizardLayout2')->name('wizard-layout-2');
        Route::get('wizard-layout-3-page', 'wizardLayout3')->name('wizard-layout-3');
        Route::get('blog-layout-1-page', 'blogLayout1')->name('blog-layout-1');
        Route::get('blog-layout-2-page', 'blogLayout2')->name('blog-layout-2');
        Route::get('blog-layout-3-page', 'blogLayout3')->name('blog-layout-3');
        Route::get('pricing-layout-1-page', 'pricingLayout1')->name('pricing-layout-1');
        Route::get('pricing-layout-2-page', 'pricingLayout2')->name('pricing-layout-2');
        Route::get('invoice-layout-1-page', 'invoiceLayout1')->name('invoice-layout-1');
        Route::get('invoice-layout-2-page', 'invoiceLayout2')->name('invoice-layout-2');
        Route::get('faq-layout-1-page', 'faqLayout1')->name('faq-layout-1');
        Route::get('faq-layout-2-page', 'faqLayout2')->name('faq-layout-2');
        Route::get('faq-layout-3-page', 'faqLayout3')->name('faq-layout-3');
        Route::get('login-page', 'login')->name('login');
        Route::get('register-page', 'register')->name('register');
        Route::get('error-page-page', 'errorPage')->name('error-page');
        Route::get('update-profile-page', 'updateProfile')->name('update-profile');
        Route::get('change-password-page', 'changePassword')->name('change-password');
        Route::get('regular-table-page', 'regularTable')->name('regular-table');
        Route::get('tabulator-page', 'tabulator')->name('tabulator');
        Route::get('modal-page', 'modal')->name('modal');
        Route::get('slide-over-page', 'slideOver')->name('slide-over');
        Route::get('notification-page', 'notification')->name('notification');
        Route::get('tab-page', 'tab')->name('tab');
        Route::get('accordion-page', 'accordion')->name('accordion');
        Route::get('button-page', 'button')->name('button');
        Route::get('alert-page', 'alert')->name('alert');
        Route::get('progress-bar-page', 'progressBar')->name('progress-bar');
        Route::get('tooltip-page', 'tooltip')->name('tooltip');
        Route::get('dropdown-page', 'dropdown')->name('dropdown');
        Route::get('typography-page', 'typography')->name('typography');
        Route::get('icon-page', 'icon')->name('icon');
        Route::get('loading-icon-page', 'loadingIcon')->name('loading-icon');
        Route::get('regular-form-page', 'regularForm')->name('regular-form');
        Route::get('datepicker-page', 'datepicker')->name('datepicker');
        Route::get('tom-select-page', 'tomSelect')->name('tom-select');
        Route::get('file-upload-page', 'fileUpload')->name('file-upload');
        Route::get('wysiwyg-editor-classic', 'wysiwygEditorClassic')->name('wysiwyg-editor-classic');
        Route::get('wysiwyg-editor-inline', 'wysiwygEditorInline')->name('wysiwyg-editor-inline');
        Route::get('wysiwyg-editor-balloon', 'wysiwygEditorBalloon')->name('wysiwyg-editor-balloon');
        Route::get('wysiwyg-editor-balloon-block', 'wysiwygEditorBalloonBlock')->name('wysiwyg-editor-balloon-block');
        Route::get('wysiwyg-editor-document', 'wysiwygEditorDocument')->name('wysiwyg-editor-document');
        Route::get('validation-page', 'validation')->name('validation');
        Route::get('chart-page', 'chart')->name('chart');
        Route::get('slider-page', 'slider')->name('slider');
        Route::get('image-zoom-page', 'imageZoom')->name('image-zoom');
    });
});
