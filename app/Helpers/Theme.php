<?php

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Classes\ThemeManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View as ViewFacade;

function activeTheme()
{
    return app(ThemeManager::class)->getActiveTheme();
}

function theme_asset($path = null)
{
    $path = $path ? '/' . $path : null;
    return asset(app(ThemeManager::class)->getActiveThemePathPrefix() . $path);
}

function theme_assets_with_version($path = null)
{
    return theme_asset($path . '?v=' . config('system.item.version'));
}

function theme_public_path($path = null)
{
    $path = $path ? '/' . $path : null;
    return public_path(app(ThemeManager::class)->getActiveThemePathPrefix() . $path);
}

function theme_resource_path($path = null)
{
    $path = $path ? '/' . $path : null;
    return resource_path('views/' . app(ThemeManager::class)->getActiveThemePathPrefix() . $path);
}

function theme_view(?string $view = null, array $data = [], array $mergeData = []): View
{
    $view = app(ThemeManager::class)->getActiveThemeViewPrefix() . '.' . $view;
    return ViewFacade::make($view, $data, $mergeData);
}

function theme_compose($views, callable $callback): void
{
    $themeManager = app(ThemeManager::class);
    if (is_array($views)) {
        foreach ($views as $view) {
            $view = $themeManager->getActiveThemeViewPrefix() . '.' . $view;
            ViewFacade::composer($view, $callback);
        }
    } else {
        $view = $themeManager->getActiveThemeViewPrefix() . '.' . $views;
        ViewFacade::composer($view, $callback);
    }
}

function themeSettings($group = null)
{
    $themeSettings = app(ThemeManager::class)->getThemeSettings();
    if ($group) {
        return $themeSettings->$group;
    }
    return $themeSettings;
}