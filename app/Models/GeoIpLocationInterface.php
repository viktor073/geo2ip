<?php

namespace App\Models;

interface GeoIpLocationInterface
{
    /**
     * Entity Fields
     */
    const LOCATION_ID = 'location_id';
    const COUNTRY = 'country';
    const CITY = 'city';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $value
     * @return GeoIpLocationInterface
     */
    public function setId(int $value): GeoIpLocationInterface;

    /**
     * @return int|null
     */
    public function getLocationId(): ?int;

    /**
     * @param int $value
     * @return GeoIpLocationInterface
     */
    public function setLocationId(int $value): GeoIpLocationInterface;

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @param string $value
     * @return GeoIpLocationInterface
     */
    public function setCountry(string $value): GeoIpLocationInterface;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param string $value
     * @return GeoIpLocationInterface
     */
    public function setCity(string $value): GeoIpLocationInterface;
}
