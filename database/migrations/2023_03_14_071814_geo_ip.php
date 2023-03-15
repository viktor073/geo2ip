<?php

use App\Models\GeoIpBlockInterface;
use App\Models\GeoIpLocationInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GeoIp extends Migration
{
    /**
     * Table Name Block
     */
    const BLOCK_TABLE_NAME = 'geo_ip_block';
    /**
     * Table Name Location
     */
    const LOCATION_TABLE_NAME = 'geo_ip_location';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::LOCATION_TABLE_NAME, function (Blueprint $table) {
            $table->unsignedBigInteger(GeoIpLocationInterface::LOCATION_ID)->nullable(false)->unique();
            $table->string(GeoIpLocationInterface::COUNTRY)->nullable(false);
            $table->string(GeoIpLocationInterface::CITY)->nullable(false);
        });

        Schema::create(self::BLOCK_TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(GeoIpBlockInterface::START_IP_NUM)->nullable(false)->index();
            $table->unsignedBigInteger(GeoIpBlockInterface::END_IP_NUM)->nullable(false)->index();
            $table
                ->foreignId(GeoIpBlockInterface::LOCATION_ID)
                ->constrained(self::LOCATION_TABLE_NAME, GeoIpLocationInterface::LOCATION_ID)
                ->cascadeOnDelete();
            $table->float(GeoIpBlockInterface::LATITUDE, 10);
            $table->float(GeoIpBlockInterface::LONGITUDE, 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::BLOCK_TABLE_NAME);
        Schema::dropIfExists(self::LOCATION_TABLE_NAME);
    }
}
