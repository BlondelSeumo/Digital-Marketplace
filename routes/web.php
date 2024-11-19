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
Route::get('cronjob', 'CronJobController@run')->name('cronjob')->middleware('demo:GET');
Route::middleware('cart')->group(function () {
    Route::middleware('maintenance')->group(function () {
        Auth::routes(['verify' => true]);
        Route::post('cookie/accept', 'GeneralController@cookie')->middleware('ajax.only');
        Route::group(['namespace' => 'Auth'], function () {
            Route::get('login', 'LoginController@showLoginForm')->name('login');
            Route::post('login', 'LoginController@login');
            Route::post('logout', 'LoginController@logout')->name('logout');
            Route::middleware(['registration.disable'])->group(function () {
                Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
                Route::post('register', 'RegisterController@register')->middleware('trustip');
            });
            Route::name('oauth.')->prefix('oauth')->group(function () {
                Route::middleware('demo:GET')->group(function () {
                    Route::get('{provider}', 'OAuthController@redirectToProvider')->name('login')->middleware('trustip');
                    Route::get('{provider}/callback', 'OAuthController@handleProviderCallback')->name('callback');
                });
                Route::middleware('auth')->group(function () {
                    Route::get('data/complete', 'OAuthController@showCompleteForm');
                    Route::post('data/complete', 'OAuthController@complete')->name('data.complete')->middleware('trustip');
                });
            });
            Route::middleware('smtp')->group(function () {
                Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
                Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            });
            Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
            Route::middleware('oauth.complete')->group(function () {
                Route::middleware('smtp')->group(function () {
                    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
                    Route::post('email/verify/email/change', 'VerificationController@changeEmail')->name('change.email');
                    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
                    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
                });
                Route::middleware(['auth', 'verified'])->group(function () {
                    Route::get('2fa/verify', 'TwoFactorController@show2FaVerifyForm');
                    Route::post('2fa/verify', 'TwoFactorController@verify2fa')->name('2fa.verify');
                });
            });
        });
        Route::prefix('user')->namespace('User')
            ->middleware(['auth', 'user', 'oauth.complete', 'verified', '2fa.verify'])->group(function () {

            Route::name('user.')->group(function () {

                Route::get('/', function () {
                    return redirect()->route('user.purchases.index');
                })->name('index');

                Route::middleware('demo')->group(function () {
                    Route::name('purchases.')->prefix('purchases')->group(function () {
                        Route::get('/', 'PurchaseController@index')->name('index');
                        Route::middleware('item_support.disable')->group(function () {
                            Route::post('{id}/support/purchase', 'PurchaseController@supportPurchase')->name('support.purchase');
                            Route::post('{id}/support/extend', 'PurchaseController@supportExtend')->name('support.extend');
                        });
                        Route::get('{id}/license', 'PurchaseController@license')->name('license');
                        Route::get('{id}/download', 'PurchaseController@download')->name('download');
                    });

                    Route::name('transactions.')->prefix('transactions')->group(function () {
                        Route::get('/', 'TransactionController@index')->name('index');
                        Route::get('{id}', 'TransactionController@show')->name('show');
                        Route::get('{id}/invoice', 'TransactionController@invoice')->name('invoice');
                    });

                    Route::name('wallet.')->prefix('wallet')->group(function () {
                        Route::get('/', 'WalletController@index')->name('index');
                        Route::post('/', 'WalletController@deposit')->name('deposit')->middleware(['deposit.disable', 'kyc.required']);
                    });

                    Route::name('refunds.')->prefix('refunds')->middleware('refunds.disable')->group(function () {
                        Route::get('/', 'RefundController@index')->name('index');
                        Route::get('create', 'RefundController@create')->name('create');
                        Route::post('store', 'RefundController@store')->name('store');
                        Route::get('{id}', 'RefundController@show')->name('show');
                        Route::post('{id}/reply', 'RefundController@reply')->name('reply');
                    });

                    Route::name('tickets.')->prefix('tickets')->middleware('tickets.disable')->group(function () {
                        Route::get('/', 'TicketController@index')->name('index');
                        Route::get('create', 'TicketController@create')->name('create');
                        Route::post('create', 'TicketController@store')->name('store');
                        Route::get('{id}', 'TicketController@show')->name('show');
                        Route::post('{id}', 'TicketController@reply')->name('reply');
                        Route::get('{id}/{attachment_id}/download', 'TicketController@download')->name('download');
                    });

                    Route::name('kyc.')->prefix('kyc')->middleware(['kyc.disable', 'kyc.verified'])->group(function () {
                        Route::get('/', 'KycController@index')->name('index');
                        Route::post('/', 'KycController@kycSubmit')->name('submit');
                    });

                    Route::name('settings.')->prefix('settings')->group(function () {
                        Route::get('/', 'SettingsController@index')->name('index');
                        Route::post('/', 'SettingsController@detailsUpdate')->name('update');
                        Route::middleware(['license:2', 'premium.disable'])->group(function () {
                            Route::post('subscription/cancel', 'SettingsController@subscriptionCancel')->name('subscription.cancel');
                        });
                        Route::post('password', 'SettingsController@passwordUpdate')->name('password.update');
                        Route::post('2fa/enable', 'SettingsController@towFactorEnable')->name('2fa.enable');
                        Route::post('2fa/disabled', 'SettingsController@towFactorDisable')->name('2fa.disable');
                    });
                });
            });
        });
    });

    Route::middleware(['oauth.complete', 'verified', '2fa.verify'])->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::post('maintenance/unlock', 'HomeController@maintenanceUnlock')->name('maintenance.unlock');

        Route::middleware('maintenance')->group(function () {
            Route::name('premium.')->prefix('premium')->middleware(['license:2', 'premium.disable'])->group(function () {
                Route::get('/', 'PremiumController@index')->name('index');
                Route::post('{id}/subscribe', 'PremiumController@subscribe')->name('subscribe')->middleware(['auth', 'user']);
            });

            Route::get('favorites', 'GeneralController@favorites')
                ->name('favorites')->middleware(['auth', 'user']);

            Route::name('categories.')->prefix('categories')->group(function () {
                Route::get('/', 'CategoryController@index')->name('index');
                Route::get('{category_slug}', 'CategoryController@category')->name('category');
                Route::get('{category_slug}/{sub_category_slug}', 'CategoryController@subCategory')->name('sub-category');
            });

            Route::name('items.')->prefix('items')->group(function () {
                Route::get('/', 'ItemController@index')->name('index');
                Route::get('preview/{id}', 'ItemController@preview')->name('preview');
                Route::name('free.')->prefix('free')->middleware('free_items_login')->group(function () {
                    Route::post('download/{id}', 'ItemController@freeDownload')->name('download');
                    Route::get('download/{id}/external', 'ItemController@freeExternalDownload')->name('download.external');
                });
                Route::middleware(['auth', 'oauth.complete', 'verified', '2fa.verify', 'kyc.required'])->group(function () {
                    Route::get('free/license/{id}', 'ItemController@freeLicense')->name('free.license');
                    Route::name('premium.')->prefix('premium')->middleware(['license:2', 'premium.disable'])->group(function () {
                        Route::post('download/{id}', 'ItemController@premiumDownload')->name('download');
                        Route::get('download/{id}/external', 'ItemController@premiumExternalDownload')->name('download.external');
                        Route::get('license/{id}', 'ItemController@premiumLicense')->name('license');
                    });
                });
                Route::middleware('item.views')->group(function () {
                    Route::get('{slug}/{id}', 'ItemController@view')->name('view');
                    Route::post('{slug}/{id}/buy-now', 'ItemController@buyNow')->name('buy-now')->middleware(['auth', 'user',
                        'buy_now.disable']);
                    Route::get('{slug}/{id}/changelogs',
                        'ItemController@changelogs')->name('changelogs')->middleware('item_changelogs.disable');
                    Route::middleware('item_reviews.disable')->group(function () {
                        Route::get('{slug}/{id}/reviews', 'ItemController@reviews')->name('reviews');
                        Route::get('{slug}/{id}/reviews/{review_id}', 'ItemController@review')->name('review');
                        Route::middleware('auth')->group(function () {
                            Route::post('{slug}/{id}/reviews', 'ItemController@reviewsStore')->name('reviews.store');
                            Route::post('{slug}/{id}/reviews/{review_id}/reply', 'ItemController@reviewsReply')->name('reviews.reply');
                        });
                    });
                    Route::middleware('item_comments.disable')->group(function () {
                        Route::get('{slug}/{id}/comments', 'ItemController@comments')->name('comments');
                        Route::get('{slug}/{id}/comments/{comment_id}', 'ItemController@comment')->name('comment');
                    });
                    Route::get('{slug}/{id}/support', 'ItemController@support')->name('support')->middleware('item_support.disable');
                });
            });

            Route::name('cart.')->prefix('cart')->middleware('user')->group(function () {
                Route::get('/', 'CartController@index')->name('index');
                Route::post('add-item', 'CartController@addItem')->name('add-item');
                Route::post('update-item/{id}', 'CartController@updateItem')->name('update-item');
                Route::post('remove-item/{id}', 'CartController@removeItem')->name('remove-item');
                Route::post('empty', 'CartController@empty')->name('empty');
            });

            Route::middleware(['auth', 'user', 'oauth.complete', 'verified', '2fa.verify', 'kyc.required'])->group(function () {
                Route::post('cart/checkout', 'CartController@checkout')->name('cart.checkout');
                Route::name('checkout.')->prefix('checkout')->group(function () {
                    Route::get('{id}', 'CheckoutController@index')->name('index');
                    Route::post('{id}', 'CheckoutController@process')->name('process')->middleware('trustip');
                });
            });

            Route::name('help.')->prefix('help')->middleware('addon.active:help_center')->group(function () {
                Route::get('/', 'HelpController@index')->name('index');
                Route::get('categories', function () {
                    return redirect()->route('help.index');
                });
                Route::get('categories/{slug}', 'HelpController@category')->name('category');
                Route::get('articles', function () {
                    return redirect()->route('help.index');
                });
                Route::get('articles/{slug}', 'HelpController@article')->name('article');
                Route::post('articles/{slug}', 'HelpController@react')->name('react');
            });

            Route::name('blog.')->prefix('blog')->middleware('blog.disable')->group(function () {
                Route::get('/', 'BlogController@index')->name('index');
                Route::get('categories', function () {
                    return redirect()->route('blog.index');
                });
                Route::get('categories/{slug}', 'BlogController@category')->name('category');
                Route::get('articles', function () {
                    return redirect()->route('blog.index');
                });
                Route::get('articles/{slug}', 'BlogController@article');
                Route::post('articles/{slug}', 'BlogController@comment')->name('article');
            });

            Route::middleware(['contact.disable', 'smtp'])->group(function () {
                Route::get('contact-us', 'GeneralController@contact');
                Route::post('contact-us', 'GeneralController@contactSend')->name('contact');
            });

            Route::get('{slug}', 'GeneralController@page')->name('page');
        });
    });
});
