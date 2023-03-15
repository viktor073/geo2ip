<?php

namespace App\Providers;

use App\Models\GeoIpBlock;
use App\Models\GeoIpBlockInterface;
use App\Models\GeoIpLocation;
use App\Models\GeoIpLocationInterface;
use App\Service\GetGeoIpBlockRepository;
use App\Service\GetGeoIpBlockRepositoryInterface;
use App\Service\PostGeoIpBlockRepository;
use App\Service\PostGeoIpBlockRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GetGeoIpBlockRepositoryInterface::class, GetGeoIpBlockRepository::class);
        $this->app->bind(PostGeoIpBlockRepositoryInterface::class, PostGeoIpBlockRepository::class);
        $this->app->bind(GeoIpBlockInterface::class, GeoIpBlock::class);
        $this->app->bind(GeoIpLocationInterface::class, GeoIpLocation::class);
    }
}
