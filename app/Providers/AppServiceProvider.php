<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\BlogArticle;
use App\Models\BlogComment;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Faq;
use App\Models\FooterLink;
use App\Models\HomeCategory;
use App\Models\Item;
use App\Models\ItemCommentReport;
use App\Models\KycVerification;
use App\Models\NavbarLink;
use App\Models\Refund;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Rules\BlockPatterns;
use App\Rules\Username;
use Carbon\Carbon;
use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerBladeDirectives();
    }

    public function boot()
    {
        Paginator::useBootstrap();

        $this->events();

        $this->validationExtends();

        if (config('system.install.complete')) {

            if (@settings('actions')->force_ssl) {
                $this->app['request']->server->set('HTTPS', true);
            }

            View::composer('*', function ($view) {
                $view->with(['settings' => @settings(), 'themeSettings' => themeSettings()]);
            });

            $this->themeViewComposers();
            $this->adminViewComposers();

            if (getDirection() == 'rtl') {
                Config::set('toastr.options.positionClass', 'vironeer-toast-top-left');
            }
        }
    }

    public function themeViewComposers()
    {
        theme_compose('includes.navbar', function ($view) {
            $navbarLinks = NavbarLink::whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->byOrder();
                }])->byOrder()->get();

            $cartItemsCount = 0;
            if (authUser() && authUser()->isUser()) {
                $user = authUser();
                if (session()->has('session_id')) {
                    $sessionId = session()->get('session_id');
                    $cartItems = CartItem::where('session_id', $sessionId)->get();
                    if ($cartItems->count() > 0) {
                        foreach ($cartItems as $cartItem) {
                            $cartItemExists = CartItem::where('user_id', $user->id)
                                ->where('item_id', $cartItem->item->id)
                                ->first();

                            if ($cartItemExists) {
                                if (($cartItemExists->quantity + $cartItem->quantity) < 50) {
                                    $cartItemExists->increment('quantity', $cartItem->quantity);
                                }
                                $cartItem->delete();
                            } else {
                                $cartItem->session_id = null;
                                $cartItem->user_id = $user->id;
                                $cartItem->update();
                            }
                        }
                    }
                    session()->forget('session_id');
                }
                $cartItemsCount = CartItem::where('user_id', $user->id)->sum('quantity');
            } else {
                if (session()->has('session_id')) {
                    $sessionId = session()->get('session_id');
                    $cartItemsCount = CartItem::where('session_id', $sessionId)->sum('quantity');
                }
            }
            $view->with([
                'navbarLinks' => $navbarLinks,
                'cartItemsCount' => $cartItemsCount,
            ]);
        });

        theme_compose('sections.categories', function ($view) {
            $categoriesSection = homeSection('categories');
            $cacheMinutes = Carbon::now()->addMinutes($categoriesSection->cache_expiry_time);
            $homeCategories = Cache::remember('home_categories_cache', $cacheMinutes, function () {
                return HomeCategory::all();
            });
            $view->with([
                'categoriesSection' => $categoriesSection,
                'homeCategories' => $homeCategories,
            ]);
        });

        theme_compose('sections.trending-items', function ($view) {
            $trendingItemsSection = homeSection('trending_items');
            $cacheMinutes = Carbon::now()->addMinutes($trendingItemsSection->cache_expiry_time);
            $trendingItems = Cache::remember('home_trending_items_cache', $cacheMinutes, function () use ($trendingItemsSection) {
                return Item::trending()
                    ->inRandomOrder()
                    ->limit($trendingItemsSection->items_number)
                    ->get();
            });
            $view->with([
                'trendingItemsSection' => $trendingItemsSection,
                'trendingItems' => $trendingItems,
            ]);
        });

        theme_compose('sections.best-selling-items', function ($view) {
            $bestSellingItemsSection = homeSection('best_selling_items');
            $cacheMinutes = Carbon::now()->addMinutes($bestSellingItemsSection->cache_expiry_time);
            $bestSellingItems = Cache::remember('home_best_selling_items_cache', $cacheMinutes, function () use ($bestSellingItemsSection) {
                return Item::bestSelling()
                    ->orderbyDesc('total_sales')
                    ->inRandomOrder()
                    ->limit($bestSellingItemsSection->items_number)
                    ->get();
            });
            $view->with([
                'bestSellingItemsSection' => $bestSellingItemsSection,
                'bestSellingItems' => $bestSellingItems,
            ]);
        });

        theme_compose('sections.sale-items', function ($view) {
            $saleItemsSection = homeSection('sale_items');
            $cacheMinutes = Carbon::now()->addMinutes($saleItemsSection->cache_expiry_time);
            $saleItems = Cache::remember('home_sale_items_cache', $cacheMinutes, function () use ($saleItemsSection) {
                return Item::onDiscount()
                    ->inRandomOrder()
                    ->limit($saleItemsSection->items_number)
                    ->get();
            });
            $view->with([
                'saleItemsSection' => $saleItemsSection,
                'saleItems' => $saleItems,
            ]);
        });

        theme_compose('sections.free-items', function ($view) {
            $freeItemsSection = homeSection('free_items');
            $cacheMinutes = Carbon::now()->addMinutes($freeItemsSection->cache_expiry_time);
            $freeItems = Cache::remember('home_free_items_cache', $cacheMinutes, function () use ($freeItemsSection) {
                return Item::free()
                    ->inRandomOrder()
                    ->limit($freeItemsSection->items_number)
                    ->get();
            });
            $view->with([
                'freeItemsSection' => $freeItemsSection,
                'freeItems' => $freeItems,
            ]);
        });

        if (licenseType(2) && @settings('premium')->status) {
            theme_compose('sections.premium-items', function ($view) {
                $premiumItemsSection = homeSection('premium_items');
                $cacheMinutes = Carbon::now()->addMinutes($premiumItemsSection->cache_expiry_time);
                $premiumItems = Cache::remember('home_premium_items_cache', $cacheMinutes, function () use ($premiumItemsSection) {
                    return Item::premium()
                        ->inRandomOrder()
                        ->limit($premiumItemsSection->items_number)
                        ->get();
                });
                $view->with([
                    'premiumItemsSection' => $premiumItemsSection,
                    'premiumItems' => $premiumItems,
                ]);
            });
        }

        theme_compose('sections.featured-items', function ($view) {
            $featuredItemsSection = homeSection('featured_items');
            $cacheMinutes = Carbon::now()->addMinutes($featuredItemsSection->cache_expiry_time);
            $featuredItems = Cache::remember('home_featured_items_cache', $cacheMinutes, function () use ($featuredItemsSection) {
                return Item::featured()
                    ->inRandomOrder()
                    ->limit($featuredItemsSection->items_number)
                    ->get();
            });
            $view->with([
                'featuredItemsSection' => $featuredItemsSection,
                'featuredItems' => $featuredItems,
            ]);
        });

        theme_compose('sections.latest-items', function ($view) {
            $latestItemsSection = homeSection('latest_items');
            $cacheMinutes = Carbon::now()->addMinutes($latestItemsSection->cache_expiry_time);
            $latestItemsCategories = Cache::remember('home_latest_items_categories_cache', $cacheMinutes, function () use ($latestItemsSection) {
                $categories = Category::all();
                foreach ($categories as $category) {
                    $category->items = $category->items()->orderByDesc('id')
                        ->limit($latestItemsSection->items_number ?? 8)->get();
                }
                return $categories;
            });
            $latestItems = Cache::remember('home_latest_items_cache', $cacheMinutes, function () use ($latestItemsSection) {
                return Item::orderByDesc('id')->limit($latestItemsSection->items_number ?? 8)->get();
            });
            $view->with([
                'latestItemsSection' => $latestItemsSection,
                'latestItems' => $latestItems,
                'latestItemsCategories' => $latestItemsCategories,
            ]);
        });

        theme_compose('sections.faqs', function ($view) {
            $faqsSection = homeSection('faqs');
            $cacheMinutes = Carbon::now()->addMinutes($faqsSection->cache_expiry_time);
            $faqs = Cache::remember('home_faqs_cache', $cacheMinutes, function () {
                return Faq::all();
            });
            $view->with([
                'faqsSection' => $faqsSection,
                'faqs' => $faqs,
            ]);
        });

        theme_compose('sections.testimonials', function ($view) {
            $testimonialsSection = homeSection('testimonials');
            $cacheMinutes = Carbon::now()->addMinutes($testimonialsSection->cache_expiry_time);
            $testimonials = Cache::remember('home_testimonials_cache', $cacheMinutes, function () {
                return Testimonial::all();
            });
            $view->with([
                'testimonialsSection' => $testimonialsSection,
                'testimonials' => $testimonials,
            ]);
        });

        theme_compose('sections.blog-articles', function ($view) {
            if (@settings('actions')->blog) {
                $blogArticlesSection = homeSection('blog_articles');
                $cacheMinutes = Carbon::now()->addMinutes($blogArticlesSection->cache_expiry_time);
                $blogArticles = Cache::remember('home_blog_articles_cache', $cacheMinutes, function () use ($blogArticlesSection) {
                    return BlogArticle::limit($blogArticlesSection->items_number ?? 3)
                        ->orderbyDesc('id')->get();
                });
                $view->with([
                    'blogArticlesSection' => $blogArticlesSection,
                    'blogArticles' => $blogArticles,
                ]);
            }
        });

        theme_compose('includes.footer', function ($view) {
            $footerLinks = FooterLink::whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->byOrder();
                }])->byOrder()->get();
            $view->with('footerLinks', $footerLinks);
        });
    }

    public function adminViewComposers()
    {
        View::composer('admin.includes.navbar', function ($view) {
            $navbarNotifications['list'] = AdminNotification::orderbyDesc('id')->limit(20)->get();
            $navbarNotifications['unread'] = AdminNotification::unread()->get()->count();
            $view->with('navbarNotifications', $navbarNotifications);
        });

        View::composer('admin.includes.sidebar', function ($view) {
            $sidebar_counters['kyc_verifications'] = KycVerification::pending()->count();
            $sidebar_counters['transactions'] = Transaction::pending()->count();
            $sidebar_counters['refunds'] = Refund::pending()->count();
            $sidebar_counters['reports.item_comments'] = ItemCommentReport::count();
            $sidebar_counters['blog_comments'] = BlogComment::pending()->count();
            $view->with('sidebar_counters', $sidebar_counters);
        });
    }

    public function validationExtends()
    {
        Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
            $rule = new Username;
            return $rule->passes($attribute, $value);
        });

        Validator::extend('block_patterns', function ($attribute, $value, $parameters, $validator) {
            $rule = new BlockPatterns;
            return $rule->passes($attribute, $value);
        });
    }

    public function registerBladeDirectives()
    {
        Blade::directive('bootstrap', function () {
            $file = getDirection() == 'rtl' ? 'bootstrap-rtl.min.css' : 'bootstrap.min.css';
            return ' <link rel="stylesheet" href="{{ asset("vendor/libs/bootstrap/' . $file . '") }}">';
        });

        Blade::directive('themeColors', function () {
            return '<link rel="stylesheet" href="' . theme_assets_with_version(config('theme.style.colors')) . '">';
        });

        Blade::directive('themeCustomStyle', function () {
            return '<link rel="stylesheet" href="' . theme_assets_with_version(config('theme.style.custom_css')) . '">';
        });

        Blade::directive('adminColors', function () {
            return '<link rel="stylesheet" href="' . asset_with_version(config('system.admin.colors')) . '">';
        });

        Blade::directive('adminCustomStyle', function () {
            return '<link rel="stylesheet" href="' . asset_with_version(config('system.admin.custom_css')) . '">';
        });
    }

    public function events()
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
            $event->extendSocialite('vkontakte', \SocialiteProviders\VKontakte\Provider::class);
            $event->extendSocialite('envato', \SocialiteProviders\Envato\Provider::class);
        });
    }
}