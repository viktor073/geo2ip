<?php

namespace App\Http\Controllers\Api\Ip2Geo;

use Illuminate\Support\Facades\Cache as CacheFacades;

class Cache
{
    /**
     * Cache Life Time In Seconds
     */
    const LIFE_TIME = 1800;
    /**
     * Prefix Cache Key
     */
    const PREFIX = 'ip_';

    /**
     * @param string $ip
     * @return array|null
     */
    static public function get(string $ip): ?array
    {
        return CacheFacades::get(self::PREFIX . $ip);
    }

    /**
     * @param string $ip
     * @param array $locationAsArray
     * @return bool
     */
    static public function put(string $ip, array $locationAsArray): bool
    {
        return \Illuminate\Support\Facades\Cache::put(
                self::PREFIX . $ip,
                $locationAsArray,
                self::LIFE_TIME
            );
    }
}
