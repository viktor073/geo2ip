<?php

namespace App\Models;

interface GeoIpBlockInterface
{
    /**
     * Entity Fields
     */
    const START_IP_NUM = 'start_ip_num';
    const END_IP_NUM = 'end_ip_num';
    const LOCATION_ID = 'location_id';
    const LATITUDE = 'latitude';
    const LONGITUDE = 'longitude';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $value
     * @return GeoIpBlockInterface
     */
    public function setId(int $value): GeoIpBlockInterface;

    /**
     * @return int|null
     */
    public function getLocationId(): ?int;

    /**
     * @param int $value
     * @return GeoIpBlockInterface
     */
    public function setLocationId(int $value): GeoIpBlockInterface;

    /**
     * @return int|null
     */
    public function getStartIpNum(): ?int;

    /**
     * @param int $value
     * @return GeoIpBlockInterface
     */
    public function setStartIpNum(int $value): GeoIpBlockInterface;

    /**
     * @return int|null
     */
    public function getEndIpNum(): ?int;

    /**
     * @param int $value
     * @return GeoIpBlockInterface
     */
    public function setEndIpNum(int $value): GeoIpBlockInterface;

    /**
     * @return float|null
     */
    public function getLatitude(): ?float;

    /**
     * @param float $value
     * @return GeoIpBlockInterface
     */
    public function setLatitude(float $value): GeoIpBlockInterface;

    /**
     * @return float|null
     */
    public function getLongitude(): ?float;

    /**
     * @param float $value
     * @return GeoIpBlockInterface
     */
    public function setLongitude(float $value): GeoIpBlockInterface;

    /**
     * @return GeoIpLocationInterface
     */
    public function getLocation(): GeoIpLocationInterface;
}
