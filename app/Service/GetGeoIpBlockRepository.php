<?php

namespace App\Service;

use App\Models\GeoIpBlock;
use App\Models\GeoIpBlockInterface;

class GetGeoIpBlockRepository implements GetGeoIpBlockRepositoryInterface
{
    /**
     * @param string $ip
     * @return GeoIpBlockInterface|null
     */
    public function getByIp(string $ip): ?GeoIpBlockInterface
    {
        if (!$this->validateIp($ip)) {
            return null;
        }

        $ip = substr($ip, 0, strrpos($ip, ".")) . '.0';
        $longIP = sprintf("%u", ip2long($ip));

        if (!empty($longIP)) {
            // TODO get with join
            /** @var GeoIpBlockInterface|GeoIpBlock $geoIpBlock */
            $geoIpBlock = GeoIpBlock::with(['GeoIpLocation'])
                ->where(GeoIpBlockInterface::START_IP_NUM, '<=', $longIP)
                ->where(GeoIpBlockInterface::END_IP_NUM, '>=', $longIP)
                ->limit(1)
                ->first();
        }

        return $geoIpBlock ?? null;
    }

    /**
     * @param ?string $ip
     * @return bool
     */
    protected function validateIp(?string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}
