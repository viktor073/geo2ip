<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class GeoIpLocation extends \Illuminate\Database\Eloquent\Model implements GeoIpLocationInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geo_ip_location';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'location_id';
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function geoIpBlocks(): HasMany
    {
        return $this->hasMany(GeoIpBlock::class, self::LOCATION_ID, self::LOCATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->getAttribute(self::LOCATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(int $value): GeoIpLocationInterface
    {
        $this->setAttribute(self::LOCATION_ID, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLocationId(): ?int
    {
        return $this->getAttribute(self::LOCATION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLocationId(int $value): GeoIpLocationInterface
    {
        $this->setAttribute(self::LOCATION_ID, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCountry(): string
    {
        return $this->getAttribute(self::COUNTRY);
    }

    /**
     * @inheritDoc
     */
    public function setCountry(string $value): GeoIpLocationInterface
    {
        $this->setAttribute(self::COUNTRY, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCity(): string
    {
        return $this->getAttribute(self::CITY);
    }

    /**
     * @inheritDoc
     */
    public function setCity(string $value): GeoIpLocationInterface
    {
        $this->setAttribute(self::CITY, $value);

        return $this;
    }
}
