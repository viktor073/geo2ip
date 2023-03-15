<?php

namespace App\Http\Controllers\Api;

use App\Models\GeoIpBlockInterface;
use App\Models\GeoIpLocationInterface;
use App\Service\GetGeoIpBlockRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Ip2GeoController extends BaseController
{
    /**
     * @var GetGeoIpBlockRepositoryInterface
     */
    private GetGeoIpBlockRepositoryInterface $getGeoIpBlockRepository;

    /**
     * @param GetGeoIpBlockRepositoryInterface $getGeoIpBlockRepository
     */
    public function __construct(GetGeoIpBlockRepositoryInterface $getGeoIpBlockRepository)
    {
        $this->getGeoIpBlockRepository = $getGeoIpBlockRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function execute(Request $request): JsonResponse
    {
        $ip = $request->get('ip', '');

        $geoIpBlockAsArray = \App\Http\Controllers\Api\Ip2Geo\Cache::get($ip);

        if (!$geoIpBlockAsArray) {
            $geoIpBlock = $this->getGeoIpBlockRepository->getByIp($ip);
            if (!empty($geoIpBlock) && $geoIpBlock->getId()) {
                $geoIpBlockAsArray = $this->prepare($geoIpBlock);
                \App\Http\Controllers\Api\Ip2Geo\Cache::put($ip, $geoIpBlockAsArray);
            }
        }

        if (empty($geoIpBlockAsArray)) {
            $result = $this->sendError('Location not found.');
        } else {
            $result = $this->sendResponse($geoIpBlockAsArray);
        }

        return $result;
    }

    /**
     * @param GeoIpBlockInterface $geoIpBlock
     * @return array
     */
    public function prepare(GeoIpBlockInterface $geoIpBlock): array
    {
        return [
            GeoIpLocationInterface::COUNTRY => $geoIpBlock->getLocation()->getCountry(),
            GeoIpLocationInterface::CITY => $geoIpBlock->getLocation()->getCity(),
            GeoIpBlockInterface::LATITUDE => $geoIpBlock->getLatitude(),
            GeoIpBlockInterface::LONGITUDE => $geoIpBlock->getLongitude(),
        ];
    }
}
