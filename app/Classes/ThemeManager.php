<?php

namespace App\Classes;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class ThemeManager
{
    public function getActiveTheme()
    {
        return Config::get('theme.active');
    }

    public function setActiveTheme($theme_alias)
    {
        Config::set('theme.active', $theme_alias);
    }

    public function getActiveThemeViewPrefix()
    {
        return 'themes.' . $this->getActiveTheme();
    }

    public function getActiveThemePathPrefix()
    {
        return 'themes/' . $this->getActiveTheme();
    }

    public function getThemeSettings()
    {
        $settingsPath = resource_path("views/themes/{$this->getActiveTheme()}/settings.json");
        $themeSettings = json_decode(File::get($settingsPath), true);

        $themeSettings = collect($themeSettings)->map(function ($group) {
            return collect($group)->pluck('value', 'key');
        });

        return json_decode(json_encode($themeSettings));
    }

}
