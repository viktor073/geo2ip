<?php

namespace App\Service;

use App\Models\GeoIpBlockInterface;

interface PostGeoIpBlockRepositoryInterface
{
    /**
     * @param array $block
     * @param string $ip
     * @return ?GeoIpBlockInterface
     * @throws \Exception
     */
    public function create(array $block, string $ip): GeoIpBlockInterface;
}
