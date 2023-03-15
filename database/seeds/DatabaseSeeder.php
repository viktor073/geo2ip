<?php

use App\Models\GeoIpBlockInterface;
use App\Models\GeoIpLocationInterface;
use App\Service\PostGeoIpBlockRepositoryInterface;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @var PostGeoIpBlockRepositoryInterface
     */
    private PostGeoIpBlockRepositoryInterface $postGeoIpBlockRepository;

    /**
     * @param PostGeoIpBlockRepositoryInterface $postGeoIpBlockRepository
     */
    public function __construct(
        PostGeoIpBlockRepositoryInterface $postGeoIpBlockRepository
    ) {
        $this->postGeoIpBlockRepository = $postGeoIpBlockRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        foreach ($this->getLocationsData() as $locationData) {
            $location = new \App\Models\GeoIpLocation();
            $location->fill($locationData)->save();
        }
        foreach ($this->getBlocksData() as $blockData) {
            $this->postGeoIpBlockRepository->create($blockData, $blockData['ip']);
        }
    }

    /**
     * @return array[]
     */
    protected function getLocationsData(): array
    {
        return [
            [
                GeoIpLocationInterface::LOCATION_ID => 1,
                GeoIpLocationInterface::COUNTRY => 'Country 1',
                GeoIpLocationInterface::CITY => 'City 1',
            ],
            [
                GeoIpLocationInterface::LOCATION_ID => 2,
                GeoIpLocationInterface::COUNTRY => 'Country 2',
                GeoIpLocationInterface::CITY => 'City 2',
            ],
        ];
    }

    /**
     * @return array[]
     */
    protected function getBlocksData(): array
    {
        return [
            [
                GeoIpBlockInterface::LOCATION_ID => 1,
                'ip'=>  '172.18.0.0/20',
                GeoIpBlockInterface::LATITUDE => 55.755831,
                GeoIpBlockInterface::LONGITUDE => 37.617673,
            ],
            [
                GeoIpBlockInterface::LOCATION_ID => 2,
                'ip'=>  '127.1.10.0/20',
                GeoIpBlockInterface::LATITUDE => 65.755831,
                GeoIpBlockInterface::LONGITUDE => 77.617673,
            ]
        ];
    }
}
