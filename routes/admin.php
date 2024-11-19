<?php

use Illuminate\Support\Facades\Route;

Route::name('admin.')->middleware('maintenance')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('index');
    Route::middleware(['auth', 'admin', '2fa.verify'])->group(function () {
        Route::middleware('demo')->group(function () {
            Route::group(['prefix' => 'dashboard'], function () {
                Route::get('/', 'DashboardController@index')->name('dashboard');
            });

            Route::post('image/upload', 'ImageUploadController@upload');

            Route::get('license-verification', 'LicenseController@index');
            Route::post('license-verification', 'LicenseController@verify')->name('license-verification');

            Route::name('notifications.')->prefix('notifications')->group(function () {
                Route::get('/', 'NotificationController@index')->name('index');
                Route::get('{notification}/view', 'NotificationController@view')->name('view');
                Route::post('read-all', 'NotificationController@readAll')->name('read.all');
                Route::delete('delete-read', 'NotificationController@deleteRead')->name('delete.read');
            });

            Route::name('members.')->prefix('members')->namespace('Members')->group(function () {
                Route::name('users.')->prefix('users')->group(function () {
                    Route::post('{user}/sendmail', 'UserController@sendMail')->name('sendmail');
                    Route::get('{user}/wallet', 'UserController@wallet')->name('wallet.index');
                    Route::post('{user}/wallet', 'UserController@walletUpdate')->name('wallet.update');
                    Route::get('{user}/password', 'UserController@showPasswordForm')->name('password.index');
                    Route::post('{user}/password', 'UserController@updatePassword')->name('password.update');
                    Route::get('{user}/actions', 'UserController@showActionsForm')->name('actions.index');
                    Route::post('{user}/actions', 'UserController@updateActions')->name('actions.update');
                    Route::get('{user}/login-logs', 'UserController@loginLogs')->name('login-logs');
                    Route::get('{user}/login', 'UserController@login')->name('login')->middleware('demo:GET');
                });
                Route::resource('users', 'UserController')->except(['show']);
                Route::name('admins.')->prefix('admins')->group(function () {
                    Route::post('{admin}/sendmail', 'AdminController@sendMail')->name('sendmail');
                    Route::get('{admin}/actions', 'AdminController@showActionsForm')->name('actions.index');
                    Route::post('{admin}/actions', 'AdminController@updateActions')->name('actions.update');
                    Route::get('{admin}/password', 'AdminController@showPasswordForm')->name('password.index');
                    Route::post('{admin}/password', 'AdminController@updatePassword')->name('password.update');
                });
                Route::resource('admins', 'AdminController')->except(['show']);
            });

            Route::name('premium.')->prefix('premium')->namespace('Premium')->middleware(['license:2'])->group(function () {
                Route::get('settings', 'SettingsController@index')->name('settings.index');
                Route::post('settings', 'SettingsController@update')->name('settings.update');
                Route::post('plans/sortable', 'PlanController@sortable')->name('plans.sortable');
                Route::resource('plans', 'PlanController')->except(['show']);
                Route::name('subscriptions.')->prefix('subscriptions')->group(function () {
                    Route::get('/', 'SubscriptionController@index')->name('index');
                    Route::get('{subscription}', 'SubscriptionController@show')->name('show');
                    Route::post('{subscription}/cancel', 'SubscriptionController@cancel')->name('cancel');
                });
            });

            Route::namespace('Items')->group(function () {
                Route::name('items.')->prefix('items')->group(function () {
                    Route::get('slug', 'ItemController@slug')->name('slug');
                    Route::post('{category_id}/upload', 'FileController@upload')->name('upload');
                    Route::post('{category_id}/files/load', 'FileController@loadFiles')->name('files.load');
                    Route::delete('{category_id}/files/{id}/delete', 'FileController@deleteFile')->name('files.delete');
                    Route::post('{item}/featured', 'ItemController@makeFeatured')->name('featured');
                    Route::post('{item}/featured/remove', 'ItemController@removeFeatured')->name('featured.remove');
                    Route::post('{item}/premium', 'ItemController@makePremium')->name('premium');
                    Route::post('{item}/premium/remove', 'ItemController@removePremium')->name('premium.remove');
                    Route::middleware('item_changelogs.disable')->group(function () {
                        Route::get('{item}/changelogs', 'ItemController@changelogs')->name('changelogs');
                        Route::post('{item}/changelogs/store', 'ItemController@changelogStore')->name('changelogs.store');
                        Route::delete('{item}/changelogs/{itemChangeLog}', 'ItemController@changelogDelete')->name('changelogs.delete');
                    });
                    Route::get('{item}/discount', 'ItemController@discount')->name('discount');
                    Route::post('{item}/discount/store', 'ItemController@discountStore')->name('discount.store');
                    Route::delete('{item}/discount', 'ItemController@discountDelete')->name('discount.delete');
                    Route::get('{item}/statistics', 'ItemController@statistics')->name('statistics');
                    Route::get('{item}/reviews', 'ItemController@reviews')->name('reviews');
                    Route::delete('{item}/reviews/{review_id}', 'ItemController@reviewsDelete')->name('reviews.delete');
                    Route::get('{item}/comments', 'ItemController@comments')->name('comments');
                    Route::delete('{item}/comments/{comment_id}', 'ItemController@commentsDelete')->name('comments.delete');
                    Route::get('{item}/download', 'ItemController@download')->name('download');
                });
                Route::resource('items', 'ItemController')->except(['show']);
            });

            Route::name('records.')->prefix('records')->namespace('Records')->group(function () {
                Route::name('statements.')->prefix('statements')->group(function () {
                    Route::get('/', 'StatementController@index')->name('index');
                    Route::delete('{statement}', 'StatementController@destroy')->name('destroy');
                });
                Route::name('sales.')->prefix('sales')->group(function () {
                    Route::get('/', 'SaleController@index')->name('index');
                    Route::get('{sale}', 'SaleController@show')->name('show');
                    Route::post('{sale}/cancel', 'SaleController@cancel')->name('cancel');
                    Route::delete('{sale}', 'SaleController@destroy')->name('destroy');
                });
                Route::name('purchases.')->prefix('purchases')->group(function () {
                    Route::get('/', 'PurchaseController@index')->name('index');
                    Route::get('{purchase}', 'PurchaseController@show')->name('show');
                });
                Route::name('support-earnings.')->prefix('support-earnings')->middleware('item_support.disable')->group(function () {
                    Route::get('/', 'SupportEarningController@index')->name('index');
                    Route::get('{supportEarning}', 'SupportEarningController@show')->name('show');
                });
                Route::name('premium-earnings.')->prefix('premium-earnings')->group(function () {
                    Route::get('/', 'PremiumEarningController@index')->name('index');
                    Route::get('{premiumEarning}', 'PremiumEarningController@show')->name('show');
                    Route::delete('{premiumEarning}', 'PremiumEarningController@destroy')->name('destroy');
                });
            });
        });

        Route::name('transactions.')->prefix('transactions')->group(function () {
            Route::get('/', 'TransactionController@index')->name('index');
            Route::get('{transaction}/review', 'TransactionController@review')->name('review');
            Route::get('{transaction}/payment-proof/view', 'TransactionController@paymentProof')->name('payment-proof');
            Route::post('{transaction}/paid', 'TransactionController@paid')->name('paid');
            Route::post('{transaction}/cancel', 'TransactionController@cancel')->name('cancel');
            Route::delete('{transaction}', 'TransactionController@destroy')->name('destroy')->middleware('demo');
        });

        Route::name('refunds.')->prefix('refunds')->middleware('refunds.disable')->group(function () {
            Route::get('/', 'RefundController@index')->name('index');
            Route::get('{refund}', 'RefundController@show')->name('show');
            Route::post('{refund}/reply', 'RefundController@reply')->name('reply');
            Route::post('{refund}/accept', 'RefundController@accept')->name('accept');
            Route::post('{refund}/decline', 'RefundController@decline')->name('decline');
            Route::delete('{refund}', 'RefundController@destroy')->name('destroy');
        });

        Route::name('ads.')->prefix('ads')->middleware('demo')->group(function () {
            Route::get('/', 'AdController@index')->name('index');
            Route::get('{ad}/edit', 'AdController@edit')->name('edit');
            Route::post('{ad}', 'AdController@update')->name('update');
        });

        Route::name('kyc.')->prefix('kyc')->namespace('Kyc')->group(function () {
            Route::get('settings', 'SettingsController@index')->name('settings');
            Route::post('settings', 'SettingsController@update')->name('settings.update');
            Route::name('kyc-verifications.')->prefix('kyc-verifications')->group(function () {
                Route::get('kyc-verifications', 'KycVerificationController@index')->name('index');
                Route::get('{kycVerification}/review', 'KycVerificationController@review')->name('review');
                Route::post('{kycVerification}/reject', 'KycVerificationController@reject')->name('reject');
                Route::post('{kycVerification}/approve', 'KycVerificationController@approve')->name('approve');
                Route::get('{kycVerification}/{document}/view', 'KycVerificationController@document')->name('document');
                Route::post('{kycVerification}/{document}/download', 'KycVerificationController@download')->name('download');
                Route::delete('{kycVerification}', 'KycVerificationController@destroy')->name('destroy')->middleware('demo');
            });
        });

        Route::name('reports.')->prefix('reports')->namespace('Reports')->group(function () {
            Route::name('item-comments.')->prefix('item-comments')->group(function () {
                Route::get('/', 'ItemCommentsController@index')->name('index');
                Route::get('{itemCommentReport}', 'ItemCommentsController@show')->name('show');
                Route::post('{itemCommentReport}/keep', 'ItemCommentsController@keep')->name('keep');
                Route::delete('{itemCommentReport}/delete', 'ItemCommentsController@delete')->middleware('demo')->name('delete');
            });
        });

        Route::middleware('demo')->group(function () {
            Route::namespace('Categories')->group(function () {
                Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
                Route::post('categories/sortable', 'CategoryController@sortable')->name('categories.sortable');
                Route::resource('categories', 'CategoryController')->except(['show']);
                Route::name('categories.')->prefix('categories')->group(function () {
                    Route::get('sub-categories/slug', 'SubCategoryController@slug')->name('sub-categories.slug');
                    Route::post('sub-categories/sortable', 'SubCategoryController@sortable')->name('sub-categories.sortable');
                    Route::resource('sub-categories', 'SubCategoryController')->except(['show']);
                    Route::post('category-options/sortable', 'CategoryOptionController@sortable')->name('category-options.sortable');
                    Route::resource('category-options', 'CategoryOptionController')->except(['show']);
                });
            });

            Route::name('tickets.')->prefix('tickets')->namespace('Tickets')->middleware('tickets.disable')->group(function () {
                Route::post('categories/sortable', 'CategoryController@sortable')->name('categories.sortable');
                Route::resource('categories', 'CategoryController')->except(['show']);
                Route::get('/', 'TicketController@index')->name('index');
                Route::get('create', 'TicketController@create')->name('create');
                Route::post('create', 'TicketController@store')->name('store');
                Route::get('{ticket}', 'TicketController@show')->name('show');
                Route::post('{ticket}', 'TicketController@reply')->name('reply');
                Route::post('{ticket}/close', 'TicketController@close')->name('close');
                Route::delete('{ticket}/delete', 'TicketController@destroy')->name('destroy');
                Route::get('{ticket}/{attachment}/download', 'TicketController@download')->name('download');
            });

            Route::name('help.')->prefix('help')->namespace('Help')->middleware('addon.active:help_center')->group(function () {
                Route::get('articles/slug', 'ArticleController@slug')->name('articles.slug');
                Route::resource('articles', 'ArticleController')->except(['show']);
                Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
                Route::post('categories/sortable', 'CategoryController@sortable')->name('categories.sortable');
                Route::resource('categories', 'CategoryController')->except(['show']);
            });

            Route::name('navigation.')->prefix('navigation')->namespace('Navigation')->group(function () {
                Route::post('navbar-links/nestable', 'NavbarLinkController@nestable')->name('navbar-links.nestable');
                Route::resource('navbar-links', 'NavbarLinkController')->except(['show']);
                Route::post('footer-links/nestable', 'FooterLinkController@nestable')->name('footer-links.nestable');
                Route::resource('footer-links', 'FooterLinkController')->except(['show']);
            });

            Route::group(['prefix' => 'blog', 'as' => 'blog.', 'namespace' => 'Blog', 'middleware' => 'blog.disable'], function () {
                Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
                Route::resource('categories', 'CategoryController')->except(['show']);
                Route::get('articles/slug', 'ArticleController@slug')->name('articles.slug');
                Route::get('articles/categories/{lang}', 'ArticleController@getCategories')->middleware('ajax.only');
                Route::resource('articles', 'ArticleController')->except(['show']);
                Route::name('comments.')->prefix('comments')->group(function () {
                    Route::get('/', 'CommentController@index')->name('index');
                    Route::get('{comment}/view', 'CommentController@viewComment')->middleware('ajax.only');
                    Route::post('{comment}/update', 'CommentController@updateComment')->name('update');
                    Route::delete('{comment}', 'CommentController@destroy')->name('destroy');
                });
            });

            Route::name('newsletter.')->prefix('newsletter')->namespace('Newsletter')->group(function () {
                Route::get('settings', 'SettingsController@index')->name('settings');
                Route::post('settings', 'SettingsController@update')->name('settings.update');
                Route::name('subscribers.')->prefix('subscribers')->group(function () {
                    Route::get('/', 'SubscriberController@index')->name('index');
                    Route::post('sendmail', 'SubscriberController@sendMail')->name('sendmail');
                    Route::post('export', 'SubscriberController@export')->name('export');
                    Route::delete('{newsletterSubscriber}', 'SubscriberController@destroy')->name('destroy');
                });
            });

            Route::name('appearance.')->prefix('appearance')->namespace('Appearance')->group(function () {
                Route::name('themes.')->prefix('themes')->group(function () {
                    Route::get('/', 'ThemeController@index')->name('index');
                    Route::post('upload', 'ThemeController@upload')->name('upload');
                    Route::post('{theme}/active', 'ThemeController@makeActive')->name('active');
                    Route::name('settings.')->prefix('{theme}/settings')->group(function () {
                        Route::get('/', 'ThemeController@showSettings')->name('index');
                        Route::get('{group}', 'ThemeController@showSettings')->name('group');
                        Route::post('{group}', 'ThemeController@updateSettings')->name('update');
                    });
                    Route::name('custom-css.')->prefix('{theme}/custom-css')->group(function () {
                        Route::get('/', 'ThemeController@showCustomCss')->name('index');
                        Route::post('/', 'ThemeController@updateCustomCss')->name('update');
                    });
                });
            });

            Route::name('faker.')->prefix('faker')->middleware('addon.active:faker')->group(function () {
                Route::get('settings', 'FakerController@settings');
                Route::post('settings', 'FakerController@settingsUpdate')->name('settings');
                Route::name('tools.')->prefix('tools')->group(function () {
                    Route::get('/', 'FakerController@tools')->name('index');
                    Route::get('{tool}', 'FakerController@tool')->name('tool');
                    Route::post('{tool}/generate', 'FakerController@generate')->name('generate');
                });
            });

            Route::name('financial.')->prefix('financial')->namespace('Financial')->group(function () {
                Route::get('settings', 'SettingsController@index');
                Route::post('settings', 'SettingsController@update')->name('settings');
                Route::resource('taxes', 'TaxController')->except(['show']);
                Route::name('payment-gateways.')->prefix('payment-gateways')->group(function () {
                    Route::get('/', 'PaymentGatewayController@index')->name('index');
                    Route::post('sortable', 'PaymentGatewayController@sortable')->name('sortable');
                    Route::get('{paymentGateway}/edit', 'PaymentGatewayController@edit')->name('edit');
                    Route::post('{paymentGateway}', 'PaymentGatewayController@update')->name('update');
                });
            });

            Route::name('settings.')->prefix('settings')->namespace('Settings')->group(function () {
                Route::get('general', 'GeneralController@index')->name('general');
                Route::post('general', 'GeneralController@update')->name('general.update');
                Route::name('item.')->prefix('item')->group(function () {
                    Route::get('/', 'ItemController@index')->name('index');
                    Route::post('/', 'ItemController@update')->name('update');
                    Route::post('storage-test', 'ItemController@storageTest')->name('storage-test');
                });
                Route::middleware('addon.active:watermark')->group(function () {
                    Route::get('watermark', 'WatermarkController@index')->name('watermark');
                    Route::post('watermark', 'WatermarkController@update')->name('watermark.update');
                });
                Route::get('ticket', 'TicketController@index')->name('ticket');
                Route::post('ticket/update', 'TicketController@update')->name('ticket.update');
                Route::middleware('item_support.disable')->group(function () {
                    Route::post('support-periods/sortable', 'SupportPeriodController@sortable')->name('support-periods.sortable');
                    Route::resource('support-periods', 'SupportPeriodController')->except(['show']);
                });
                Route::name('oauth-providers.')->prefix('oauth-providers')->group(function () {
                    Route::get('/', 'OAuthProviderController@index')->name('index');
                    Route::get('{oauthProvider}/edit', 'OAuthProviderController@edit')->name('edit');
                    Route::post('{oauthProvider}', 'OAuthProviderController@update')->name('update');
                });
                Route::name('captcha-providers.')->prefix('captcha-providers')->group(function () {
                    Route::get('/', 'CaptchaProviderController@index')->name('index');
                    Route::get('{captchaProvider}/edit', 'CaptchaProviderController@edit')->name('edit');
                    Route::post('{captchaProvider}', 'CaptchaProviderController@update')->name('update');
                    Route::post('{captchaProvider}/default', 'CaptchaProviderController@makeDefault')->name('default');
                });
                Route::name('smtp.')->prefix('smtp')->group(function () {
                    Route::get('/', 'SmtpController@index')->name('index');
                    Route::post('update', 'SmtpController@update')->name('update');
                    Route::post('test', 'SmtpController@test')->name('test');
                });
                Route::get('pages/slug', 'PageController@slug')->name('pages.slug');
                Route::resource('pages', 'PageController')->except(['show']);
                Route::name('extensions.')->prefix('extensions')->group(function () {
                    Route::get('/', 'ExtensionController@index')->name('index');
                    Route::get('{extension}/edit', 'ExtensionController@edit')->name('edit');
                    Route::post('{extension}', 'ExtensionController@update')->name('update');
                });
                Route::name('language.')->prefix('language')->group(function () {
                    Route::get('/', 'LanguageController@index')->name('index');
                    Route::post('/', 'LanguageController@update')->name('update');
                    Route::name('translates.')->prefix('translates')->group(function () {
                        Route::get('/', 'LanguageController@translates')->name('index');
                        Route::post('/', 'LanguageController@translatesUpdate')->name('update');
                    });
                });
                Route::name('mail-templates.')->prefix('mail-templates')->group(function () {
                    Route::get('/', 'MailTemplateController@index')->name('index');
                    Route::get('{mailTemplate}/edit', 'MailTemplateController@edit')->name('edit');
                    Route::post('{mailTemplate}', 'MailTemplateController@update')->name('update');
                });
            });

            Route::name('sections.')->namespace('Sections')->prefix('sections')->group(function () {
                Route::name('announcement.')->prefix('announcement')->group(function () {
                    Route::get('/', 'AnnouncementController@index')->name('index');
                    Route::post('/', 'AnnouncementController@update')->name('update');
                });
                Route::name('home-sections.')->prefix('home-sections')->group(function () {
                    Route::get('/', 'HomeSectionController@index')->name('index');
                    Route::post('sortable', 'HomeSectionController@sortable')->name('sortable');
                    Route::get('{homeSection}/edit', 'HomeSectionController@edit')->name('edit');
                    Route::post('{homeSection}', 'HomeSectionController@update')->name('update');
                });
                Route::post('home-categories/sortable', 'HomeCategoryController@sortable')->name('home-categories.sortable');
                Route::resource('home-categories', 'HomeCategoryController')->except(['show']);
                Route::post('faqs/sortable', 'FaqController@sortable')->name('faqs.sortable');
                Route::resource('faqs', 'FaqController')->except(['show']);
                Route::post('testimonials/sortable', 'TestimonialController@sortable')->name('testimonials.sortable');
                Route::resource('testimonials', 'TestimonialController')->except(['show']);
            });

            Route::name('system.')->namespace('System')->prefix('system')->group(function () {
                Route::get('info', 'InfoController@index')->name('info.index');
                Route::get('info/cache', 'InfoController@cache')->name('info.cache')->middleware('demo:GET');
                Route::get('maintenance', 'MaintenanceController@index');
                Route::post('maintenance', 'MaintenanceController@update')->name('maintenance');
                Route::name('addons.')->prefix('addons')->group(function () {
                    Route::get('/', 'AddonController@index')->name('index');
                    Route::post('/', 'AddonController@upload')->name('upload');
                    Route::post('{addon}/update', 'AddonController@update')->name('update');
                });
                Route::get('admin-panel-style', 'AdminPanelStyleController@index');
                Route::post('admin-panel-style', 'AdminPanelStyleController@update')->name('admin-panel-style');
                Route::name('cronjob.')->prefix('cronjob')->group(function () {
                    Route::get('/', 'CronJobController@index')->name('index');
                    Route::post('key-generate', 'CronJobController@keyGenerate')->name('key-generate');
                    Route::post('key-remove', 'CronJobController@keyRemove')->name('key-remove');
                    Route::post('run', 'CronJobController@run')->name('run');
                });
                Route::name('api.')->prefix('api')->group(function () {
                    Route::get('/', 'ApiController@index')->name('index');
                    Route::post('/', 'ApiController@update')->name('update');
                    Route::post('key-generate', 'ApiController@keyGenerate')->name('key-generate');
                });
            });

            Route::name('account.')->prefix('account')->group(function () {
                Route::get('/', 'AccountController@index')->name('index');
                Route::post('details', 'AccountController@updateDetails')->name('details');
                Route::post('password', 'AccountController@updatePassword')->name('password');
                Route::post('2fa/enable', 'AccountController@enable2FA')->name('2fa.enable');
                Route::post('2fa/disable', 'AccountController@disable2FA')->name('2fa.disable');
            });
        });
    });
});