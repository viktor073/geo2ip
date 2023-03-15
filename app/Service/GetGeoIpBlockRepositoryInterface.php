<?php

namespace App\Service;

use App\Models\GeoIpBlockInterface;

interface GetGeoIpBlockRepositoryInterface
{
    /**
     * @param string $ip
     * @return ?GeoIpBlockInterface
     */
    public function getByIp(string $ip): ?GeoIpBlockInterface;
}
