<?php

namespace App\Classes;

use Illuminate\Support\Facades\Cache;

class IPLookup
{
    public function getData($ip = null)
    {
        $ip = $ip ?? getIp();
        $ipInfo = $this->lookup($ip);
        $data['ip'] = $ipInfo->query ?? $ip;
        $data['country'] = $ipInfo->country ?? 'Unknown';
        $data['country_code'] = $ipInfo->countryCode ?? 'Unknown';
        $data['timezone'] = $ipInfo->timezone ?? 'Unknown';
        $data['city'] = $ipInfo->city ?? 'Unknown';
        $data['zip'] = $ipInfo->zip ?? 'Unknown';
        $data['latitude'] = $ipInfo->lat ?? 'Unknown';
        $data['longitude'] = $ipInfo->lon ?? 'Unknown';
        $data['location'] = $data['city'] . ', ' . $data['country_code'];
        $data['currency'] = $ipInfo->currency ?? 'Unknown';
        return (object) $data;

    }

    protected function lookup($ip)
    {
        if (Cache::has($ip)) {
            $ipInfo = Cache::get($ip);
        } else {
            $fields = "status,country,countryCode,city,lat,lon,timezone,query";
            $ipInfo = (object) json_decode(curl_get_file_contents("http://ip-api.com/json/{$ip}?fields={$fields}"), true);
            Cache::forever($ip, $ipInfo);
        }
        return $ipInfo;
    }
}