<?php

namespace App\Service;

use App\Models\GeoIpBlock;
use App\Models\GeoIpBlockInterface;

class PostGeoIpBlockRepository implements PostGeoIpBlockRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $block, string $ip): GeoIpBlockInterface
    {
        list($ip, $mask) = explode('/', $ip ?? '');
        if (!$this->validate($block, $ip)) {
            throw new \Exception('Creating an Geo IP block: not valid data.');
        }
       $minMaxIp = $this->prepareIp($ip, $mask);

        $geoIpBlock = new GeoIpBlock();
        $geoIpBlock
            ->setLocationId($block[GeoIpBlockInterface::LOCATION_ID])
            ->setStartIpNum($minMaxIp['min'])
            ->setEndIpNum($minMaxIp['max'])
            ->setLatitude($block[GeoIpBlockInterface::LATITUDE] ?? null)
            ->setLongitude($block[GeoIpBlockInterface::LONGITUDE] ?? null);

        $geoIpBlock->save();

        return $geoIpBlock;
    }

    /**
     * @param string $ip
     * @param int $mask
     * @return int[]
     */
    public function prepareIp(string $ip, int $mask): array
    {
        $ip2long = ip2long($ip);
        $min = ($ip2long >> (32 - $mask)) << (32 - $mask);
        $max = $ip2long | ~(-1 << (32 - $mask));

        return ['min' => $min, 'max' => $max];
    }

    /**
     * @param array $block
     * @param string $ip
     * @return bool
     */
    protected function validate(array $block, string $ip): bool
    {
        return !empty($block[GeoIpBlockInterface::LOCATION_ID])
            && filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}
