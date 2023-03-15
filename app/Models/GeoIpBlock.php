<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeoIpBlock extends \Illuminate\Database\Eloquent\Model implements GeoIpBlockInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geo_ip_block';

    /**
     * @return BelongsTo
     */
    public function geoIpLocation(): BelongsTo
    {
        return $this->belongsTo(GeoIpLocation::class, self::LOCATION_ID);
    }

    /**
     * @return GeoIpLocationInterface
     */
    public function getLocation(): GeoIpLocationInterface
    {
        /** @var GeoIpLocationInterface $location */
        $location = $this->geoIpLocation()->first();

        return $location;
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
    public function setLocationId(int $value): GeoIpBlockInterface
    {
        $this->setAttribute(self::LOCATION_ID, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->getAttribute('id');
    }

    /**
     * @inheritDoc
     */
    public function setId(int $value): GeoIpBlockInterface
    {
        $this->setAttribute('id', $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStartIpNum(): ?int
    {
        return $this->getAttribute(self::START_IP_NUM);
    }

    /**
     * @inheritDoc
     */
    public function setStartIpNum(int $value): GeoIpBlockInterface
    {
        $this->setAttribute(self::START_IP_NUM, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEndIpNum(): ?int
    {
        return $this->geoIpBlock()->getAttribute(self::END_IP_NUM);
    }

    /**
     * @inheritDoc
     */
    public function setEndIpNum(int $value): GeoIpBlockInterface
    {
        $this->setAttribute(self::END_IP_NUM, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLatitude(): ?float
    {
        return $this->getAttribute(self::LATITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLatitude(float $value): GeoIpBlockInterface
    {
        $this->setAttribute(self::LATITUDE, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLongitude(): ?float
    {
        return $this->getAttribute(self::LONGITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLongitude(float $value): GeoIpBlockInterface
    {
        $this->setAttribute(self::LONGITUDE, $value);

        return $this;
    }
}
