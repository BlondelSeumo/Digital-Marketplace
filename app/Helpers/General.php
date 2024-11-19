<?php

use App\Classes\Country;
use App\Classes\IPLookup;
use App\Classes\SchemaGenerator;
use App\Classes\ThemeManager;
use App\Methods\Dotenv;
use App\Models\Addon;
use App\Models\AdminNotification;
use App\Models\CaptchaProvider;
use App\Models\Extension;
use App\Models\HomeSection;
use App\Models\MailTemplate;
use App\Models\PaymentGateway;
use App\Models\Settings;
use App\Models\StorageProvider;
use App\Models\SupportPeriod;
use App\Models\Translate;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;
use Mews\Purifier\Facades\Purifier;

function demoMode()
{
    return config('system.demo_mode');
}

function demo($content = null)
{
    if ($content && config('system.demo_mode')) {
        return translate('[Hidden In Demo]');
    }
    return $content;
}

function asset_with_version($path)
{
    return asset($path . '?v=' . config('system.item.version'));
}

function authUser()
{
    return Auth::user();
}

function adminPath()
{
    return config('system.admin.path');
}

function adminUrl($path = null)
{
    $url = url(adminPath());
    if ($path) {
        $url = $url . '/' . $path;
    }
    return $url;
}

function adminNotify($title, $image, $link = null, $linkTypeExternal = false)
{
    $notify = new AdminNotification();
    $notify->title = $title;
    $notify->image = $image;
    $notify->link = $link;
    if ($linkTypeExternal) {
        $notify->link_type = AdminNotification::LINK_TYPE_EXTERNAL;
    }
    $notify->save();
}

function admcw($counter)
{
    return $counter > 99 ? '+99' : $counter;
}

function settings($key = null)
{
    if (!empty($key)) {
        return Settings::selectSettings($key);
    }
    $settings = Settings::pluck('value', 'key')->all();
    return json_decode(json_encode($settings), false);
}

function extension($alias)
{
    return Extension::where('alias', $alias)->first();
}

function captchaProvider($alias)
{
    return CaptchaProvider::where('alias', $alias)->first();
}

function addonBadge($alias)
{
    if (config('system.demo_mode')) {
        $addon = Addon::where('alias', $alias)->first();
        if ($addon) {
            return '<span class="badge bg-primary py-1 px-2 ms-2"><small>' . translate('Addon') . '</small></span>';
        }
    }
    return null;
}

function isAddonActive($alias)
{
    $addon = Addon::where('alias', $alias)->first();
    if ($addon) {
        if ($addon->hasNoStatus() || $addon->isActive()) {
            return true;
        }
    }
    return false;
}

function errorsLayout()
{
    if (config('system.install.complete')) {
        if (request()->segment(1) == adminPath() && authUser() && authUser()->isAdmin()) {
            return 'admin.layouts.errors';
        } else {
            $themeManager = app(ThemeManager::class);
            $themeViewPrefix = $themeManager->getActiveThemeViewPrefix();
            if (request()->segment(1) == 'user') {
                return $themeViewPrefix . '.user.layouts.errors';
            } else {
                return $themeViewPrefix . '.layouts.errors';
            }
        }
    }

    return 'errors.layout';
}

function dateFormat($date, $format = null)
{
    Date::setLocale(getLocale());
    if (!$format) {
        $format = Settings::dateFormats()[@settings('general')->date_format];
    }
    $dateFormat = Date::parse($date)->format($format);
    return $dateFormat;
}

function generateUniqueFileName($file, $specificName = null)
{
    if (!empty($specificName)) {
        $filename = $specificName . '.' . $file->getClientOriginalExtension();
    } else {
        $filename = Str::random(15) . '_' . time() . '.' . $file->getClientOriginalExtension();
    }
    return $filename;
}

function imageUpload($image, $location, $size = null, $specificName = null, $old = null)
{
    makeDirectory(public_path($location));
    if (!empty($old)) {
        removeFile(public_path($old));
    }
    $filename = generateUniqueFileName($image, $specificName);
    if (!empty($size)) {
        $image = Image::make($image);
        $width = $image->width();
        $height = $image->height();
        $newSize = explode('x', strtolower($size));
        if ($newSize[0] != $width && $newSize[1] != $height) {
            $image->resize($newSize[0], $newSize[1]);
        }
        $image->save(public_path($location . $filename));
    } else {
        $image->move(public_path($location), $filename);
    }
    return $location . $filename;
}

function fileUpload($file, $location, $specificName = null, $old = null)
{
    makeDirectory(public_path($location));
    if (!empty($old)) {
        removeFile(public_path($old));
    }
    $filename = generateUniqueFileName($file, $specificName);
    $file->move(public_path($location), $filename);
    return $location . $filename;
}

function storageFileUpload($file, $location, $disk, $specificName = null, $old = null)
{
    if (!empty($old)) {
        removeFileFromStorage($old, $disk);
    }
    $filename = generateUniqueFileName($file, $specificName);
    $filePath = $location . $filename;
    Storage::disk($disk)->put($filePath, fopen($file, 'r+'));
    return $filePath;
}

function removeFileFromStorage($path, $disk)
{
    $disk = Storage::disk($disk);
    if ($disk->has($path)) {
        $disk->delete($path);
    }
    return true;
}

function removeFile($path)
{
    if (File::exists($path)) {
        File::delete($path);
    }
    return true;
}

function removeDirectory($path)
{
    if (File::exists($path)) {
        File::deleteDirectory($path);
    }
    return true;
}

function makeDirectory($path)
{
    if (!File::exists($path)) {
        File::makeDirectory($path, 0775, true);
    }
    return true;
}

function shorterText($text, $chars_limit)
{
    return Str::limit($text, $chars_limit, $end = '...');
}

function purifier($content)
{
    $purifier = new \HTMLPurifier();
    $content = $purifier->purify($content);
    return nl2br(e($content));
}

function purifierClean($content)
{
    $content = Purifier::clean($content);
    if (empty($content)) {
        $content = null;
    }
    return $content;
}

function setEnv($key, $value, $quote = false)
{
    $env = new Dotenv();
    return $env->setKey($key, $value, $quote);
}

function getLocale()
{
    return App::getLocale();
}

function getDirection()
{
    return config('app.direction');
}

function translate($key, $replace = [])
{
    if (config('system.install.complete')) {
        $slug = sha1($key);
        $translation = Cache::rememberForever('translation_' . $slug, function () use ($key) {
            return Translate::where('key', $key)->first();
        });

        if (!$translation) {
            $translation = new Translate();
            $translation->key = $key;
            $translation->value = $key;
            $translation->save();
            Cache::forever('translation_' . $slug, $translation);
        }
        $translatedText = $translation->value;
    } else {
        $translatedText = $key;
    }

    foreach ($replace as $placeholder => $value) {
        $translatedText = str_replace(':' . $placeholder, $value, $translatedText);
    }

    return $translatedText;
}

function translate_choice($key, $number, $replace = [])
{
    $translated = translate($key, $replace);
    $parts = explode('|', $translated);

    if ($number == 1) {
        $chosen = $parts[0];
    } else {
        $chosen = end($parts);
    }

    $replace['count'] = $number;

    foreach ($replace as $placeholder => $value) {
        $chosen = str_replace(':' . $placeholder, $value, $chosen);
    }

    return $chosen;
}

function mailTemplate($alias)
{
    $mailTemplate = MailTemplate::where('alias', $alias)->first();
    return $mailTemplate;
}

function pageTitle($env)
{
    $name = @settings('general')->site_name;

    $title = $env->yieldContent('title') ? ' — ' . $env->yieldContent('title') : '';
    $section = $env->yieldContent('section') ? ' — ' . $env->yieldContent('section') : '';

    return $name . $section . $title;
}

function seoTitle($env)
{
    $name = @settings('general')->site_name;

    $title = $env->yieldContent('title') ? $env->yieldContent('title') : '';
    $section = $env->yieldContent('section') ? $env->yieldContent('section') : '';

    $seoTitle = $section ? trim($section . ' - ' . $title) : $title;

    if (!empty($seoTitle)) {
        $seoTitle .= ' | ' . $name;
    } else {
        $seoTitle = $name;
    }

    return $seoTitle;
}

function chartDates($startDate, $endDate, $format = 'Y-m-d')
{
    $dates = collect();
    $startDate = $startDate->copy();
    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        $dates->put($date->format($format), 0);
    }
    return $dates;
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) {
        return $contents;
    } else {
        return false;
    }
}

function getIp()
{
    $ip = null;
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    } else {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
    }
    return $ip;
}

function ipInfo()
{
    return app(IPLookup::class)->getData();
}

function countries($code = null)
{
    return $code ? Country::get($code) : Country::all();
}

function hash_encode($id, $length = 12)
{
    $hashids = new Hashids('', $length);
    return $hashids->encode($id);
}

function hash_decode($id, $length = 12)
{
    $hashids = new Hashids('', $length);
    return $hashids->decode($id);
}

function schema($__env, $method = null, $options = [])
{
    return app(SchemaGenerator::class)->render($__env, $method, $options);
}

function price($price)
{
    return number_format($price, 2);
}

function amountFormat($amount, $decimals = 2, $decimalSeparator = '.', $thousandsSeparator = '', $hideNegativeDecimals = false)
{
    if ($hideNegativeDecimals && intval($amount) == $amount) {
        return number_format($amount, 0, $decimalSeparator, $thousandsSeparator);
    }

    return number_format((float) $amount, $decimals, $decimalSeparator, $thousandsSeparator);
}

function getAmount($amount, $decimals = 2, $decimalSeparator = '.', $thousandsSeparator = ',', $hideNegativeDecimals = false)
{
    $amount = amountFormat($amount, $decimals, $decimalSeparator, $thousandsSeparator, $hideNegativeDecimals);
    $symbol = @settings('currency')->symbol;
    if (@settings('currency')->position == 1) {
        return $symbol . $amount;
    } else {
        return $amount . $symbol;
    }
}

function paymentGateway($alias)
{
    $paymentGateway = PaymentGateway::where('alias', $alias)
        ->active()->first();
    return $paymentGateway;
}

function numberFormat($number)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];
    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && $number % 1000 != 0) ? 1 : 0;
            $number = number_format($display, $decimals) . $abbrev;
            break;
        }
    }
    return $number;
}

function storageProvider($alias = null)
{
    if ($alias) {
        $storageProvider = StorageProvider::where('alias', $alias)->first();
    }
    $storageProvider = StorageProvider::default()->first();
    return $storageProvider;
}

function getLinkFromStorageProvider($filePath)
{
    $storageProvider = storageProvider();
    if ($storageProvider->isLocal()) {
        return asset($filePath);
    } elseif ($storageProvider->isStorj()) {
        $filePath = $filePath . '?wrap=0';
    }
    return $storageProvider->credentials->url . '/' . $filePath;
}

function formatBytes($bytes, $precision = 2)
{
    if ($bytes) {
        $units = [translate('B'), translate('KB'), translate('MB'),
            translate('GB'), translate('TB'), translate('PB')];
        $index = floor(log($bytes, 1024));
        $size = round($bytes / pow(1024, $index), $precision);
        return sprintf('%s %s', $size, $units[$index]);

    }
    return $bytes;
}

function homeSection($alias)
{
    $homeSection = HomeSection::where('alias', $alias)
        ->active()->first();
    return $homeSection;
}

function countryFlag($country)
{
    $country = strtoupper($country);
    return "https://flagsapi.com/{$country}/flat/64.png";
}

function generateMonthRangeFromDate($date)
{
    $startMonth = Date::parse($date)->startOfMonth();
    $currentMonth = Date::now()->startOfMonth();
    $months = [];
    while ($startMonth->lte($currentMonth)) {
        $months[] = [
            "key" => $startMonth->format('Y-m'),
            "value" => $startMonth->format('F Y'),
        ];
        $startMonth->addMonth();
    }
    return collect($months)->sortByDesc('key');
}

function incrementViews($query, $alias)
{
    $key = sha1($alias);
    $viewed = Cookie::get($key) ? json_decode(Cookie::get($key), true) : [];

    if (!in_array($query->id, $viewed)) {
        $query->increment('views');
        $viewed[] = $query->id;
        Cookie::queue($key, json_encode($viewed), 1440);
    }
}

function supportPeriods()
{
    return SupportPeriod::all();
}

function defaultSupportPeriod()
{
    return SupportPeriod::default()->first();
}
