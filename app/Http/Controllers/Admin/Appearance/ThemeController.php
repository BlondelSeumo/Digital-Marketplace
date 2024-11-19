<?php

namespace App\Http\Controllers\Admin\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Str;
use Validator;
use ZipArchive;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('admin.appearance.themes.index', ['themes' => $themes]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_code' => ['required', 'string'],
            'theme_files' => ['required', 'mimes:zip'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if (!class_exists('ZipArchive')) {
            toastr()->error(translate('ZipArchive extension is not enabled'));
            return back();
        }

        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $request->purchase_code)) {
            if (!preg_match("/^([d-u0-9]{10})-(([d-u0-9]{5})-){3}([d-u0-9]{10})$/i", $request->purchase_code)) {
                toastr()->error(translate('Invalid purchase code'));
                return back();
            }
        }

        try {

            $themeZipFile = storageFileUpload($request->file('theme_files'), 'temp/', 'local');
            $themeUploadPath = storage_path("app/{$themeZipFile}");

            $tempFolder = md5(Str::random(10) . time());
            $themeTempPath = storage_path("app/temp/{$tempFolder}");

            if (File::exists($themeTempPath)) {
                removeDirectory($themeTempPath);
            }

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        try {

            $zip = new ZipArchive;
            $res = $zip->open($themeUploadPath);
            if ($res != true) {
                throw new Exception(translate('Could not open the theme zip file'));
            }

            $res = $zip->extractTo($themeTempPath);
            if ($res == true) {
                removeFile($themeUploadPath);
            }

            $zip->close();

            $configFile = "{$themeTempPath}/config.json";
            if (!File::exists($configFile)) {
                throw new Exception(translate('Theme Config is missing'));
            }

            $config = json_decode(File::get($configFile), true);

            if ($config['type'] != "theme") {
                throw new Exception(translate('Invalid theme files'));
            }

            if (isInLiveServer()) {
                $response = purchaseCodeValidation($request->purchase_code, $config['alias']);
                if (isset($response->status)) {
                    if ($response->status == "error") {
                        throw new Exception($response->message);
                    }
                } else {
                    throw new Exception(translate('Failed to validate the purchase code'));
                }
            }

            $scriptAlias = $config['script']['alias'];
            $scriptVersion = $config['script']['version'];

            if (strtolower(config('system.item.alias')) != strtolower($scriptAlias)) {
                throw new Exception(translate('Invalid action request'));
            }

            if (config('system.item.version') < $scriptVersion) {
                throw new Exception(str_replace(translate("The {theme_name} theme require {script_alias} version {script_version} or above"),
                    ['{theme_name}', '{script_alias}', '{script_version}'],
                    [$config['name'], $scriptAlias, $scriptVersion]
                ));
            }

            $isUpdate = $config['update'];
            $themeExists = Theme::where('alias', $config['alias'])->first();
            if (!$isUpdate) {
                if ($themeExists) {
                    throw new Exception(translate('The :theme_name theme is already exists.', ['theme_name' => $config['name']]));
                }
            } else {
                if (!$themeExists) {
                    throw new Exception(translate('The {theme_name} is not exists to make the update.', ['theme_name' => $config['name']]));
                }
            }

            if (!empty($config['remove'])) {
                $removeDirectories = $config['remove']['directories'];
                if (!empty($removeDirectories)) {
                    foreach ($removeDirectories as $removeDirectory) {
                        removeDirectory(base_path($removeDirectory));
                    }
                }
                $removeFiles = $config['remove']['files'];
                if (!empty($removeFiles)) {
                    foreach ($removeFiles as $removeFile) {
                        removeFile(base_path($removeFile));
                    }
                }
            }

            if (!empty($config['create'])) {
                $createDirectories = $config['create']['directories'];
                if (!empty($createDirectories)) {
                    foreach ($createDirectories as $createDirectory) {
                        makeDirectory(base_path($createDirectory));
                    }
                }
            }

            if (!empty($config['copy'])) {
                $copyDirectories = $config['copy']['directories'];
                if (!empty($copyDirectories)) {
                    foreach ($copyDirectories as $copyDirectory) {
                        File::copyDirectory("{$themeTempPath}/{$copyDirectory}", base_path($copyDirectory));
                    }
                }
                $copyFiles = $config['copy']['files'];
                if (!empty($copyFiles)) {
                    foreach ($copyFiles as $copyFile) {
                        File::copy("{$themeTempPath}/{$copyFile}", base_path($copyFile));
                    }
                }
            }

            if (!empty($config['database'])) {
                $databaseFiles = $config['database']['files'];
                if (!empty($databaseFiles)) {
                    foreach ($databaseFiles as $databaseFile) {
                        $databaseFile = "{$themeTempPath}/{$databaseFile}";
                        if (File::exists($databaseFile)) {
                            $unprepared = DB::unprepared(File::get($databaseFile));
                            if (!$unprepared) {
                                throw new Exception(translate("Cannot unprepared the database file"));
                            }
                        }
                    }
                }
            }

            $theme = Theme::updateOrCreate(['alias' => $config['alias']], [
                'name' => $config['name'],
                'version' => $config['version'],
                'preview_image' => $config['preview_image'],
                'description' => $config['description'],
            ]);

            if ($theme) {
                removeDirectory($themeTempPath);
                toastr()->success(translate('Theme uploaded successfully'));
                return back();
            }

        } catch (Exception $e) {
            removeFile($themeUploadPath);
            removeDirectory($themeTempPath);
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function makeActive(Request $request, Theme $theme)
    {
        setEnv('DEFAULT_THEME', $theme->alias);
        Artisan::call('optimize:clear');
        toastr()->success(translate('Theme has been changed Successfully'));
        return back();
    }

    public function showSettings(Request $request, Theme $theme, $group = 'general')
    {
        $themeSettingsFile = resource_path("views/themes/{$theme->alias}/settings.json");
        if (!File::exists($themeSettingsFile)) {
            die(translate('Settings file is missing'));
        }

        $themeSettings = json_decode(File::get($themeSettingsFile));

        abort_if(!isset($themeSettings->$group), 404);

        $themeSettingsGroups = collect($themeSettings)->keys();
        $themeSettingsCollection = collect($themeSettings->$group);

        return view('admin.appearance.themes.settings', [
            'theme' => $theme,
            'activeGroup' => $group,
            'themeSettingsGroups' => $themeSettingsGroups,
            'themeSettingsCollection' => $themeSettingsCollection,
        ]);
    }

    public function updateSettings(Request $request, Theme $theme, $group = 'general')
    {
        $themeSettingsFile = resource_path("views/themes/{$theme->alias}/settings.json");
        if (!File::exists($themeSettingsFile)) {
            die(translate('Settings file is missing'));
        }

        $themeSettings = json_decode(File::get($themeSettingsFile));
        abort_if(!isset($themeSettings->$group), 404);

        try {

            $validationRules = [];
            $settingKeys = [];
            foreach ($themeSettings->$group as $setting) {
                if (isset($setting->key, $setting->rule)) {
                    $validationRules[$setting->key] = $setting->rule;
                    $settingKeys[] = $setting->key;
                }
            }

            $requestData = $request->only($settingKeys);
            $validator = Validator::make($requestData, $validationRules);
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    toastr()->error($error);
                }
                return back();
            }

            foreach ($themeSettings->$group as $setting) {
                if (in_array($setting->field, ['checkbox', 'toggle'])) {
                    $requestData[$setting->key] = $request->has($setting->key) ? 1 : 0;
                } elseif (in_array($setting->field, ['select', 'bootstrap-select', 'radios'])) {
                    if (!array_key_exists($request->input($setting->key), (array) $setting->options)) {
                        toastr()->error(translate('Failed to update :label', ['label' => $setting->label]));
                        return back();
                    }
                } elseif ($setting->field == "image") {
                    if ($request->has($setting->key)) {
                        $size = isset($setting->size) && $setting->size != null ? $setting->size : null;
                        $name = isset($setting->name) && $setting->name != null ? $setting->name : null;
                        $requestData[$setting->key] = imageUpload($request->file($setting->key), "themes/{$theme->alias}/{$setting->path}", $size, $name, $setting->value);
                    }
                }
            }

            foreach ($themeSettings->$group as &$setting) {
                if (isset($setting->key)) {
                    if (array_key_exists($setting->key, $requestData)) {
                        $setting->value = $requestData[$setting->key];
                    }
                }
            }

            File::put($themeSettingsFile, json_encode($themeSettings, JSON_PRETTY_PRINT));
            $this->updateThemeColors($theme, $themeSettings->colors);

            toastr()->success(translate('Updated Successfully'));
            return back();

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function updateThemeColors($theme, $themeColors)
    {
        $output = ':root {' . PHP_EOL;
        foreach ($themeColors as &$color) {
            $output .= '  --' . $color->key . ': ' . $this->hexToRgb($color->value) . ';' . PHP_EOL;
        }
        $output .= '}' . PHP_EOL;
        $colorsPath = config('theme.style.colors');
        $colorsFile = public_path("themes/{$theme->alias}/{$colorsPath}");
        return File::put($colorsFile, $output);
    }

    public function showCustomCss(Theme $theme)
    {
        $customCssPath = config('theme.style.custom_css');
        $customCssFile = public_path("themes/{$theme->alias}/{$customCssPath}");
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        $themeCustomCssFile = File::get($customCssFile);
        return view('admin.appearance.themes.custom-css', [
            'theme' => $theme,
            'themeCustomCssFile' => $themeCustomCssFile,
        ]);
    }

    public function updateCustomCss(Request $request, Theme $theme)
    {
        $customCssPath = config('theme.style.custom_css');
        $customCssFile = public_path("themes/{$theme->alias}/{$customCssPath}");
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        File::put($customCssFile, $request->custom_css);
        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return $r . ', ' . $g . ', ' . $b;
    }
}