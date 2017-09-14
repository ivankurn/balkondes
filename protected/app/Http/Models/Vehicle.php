<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property VehicleType $vehicleType
 * @property DriverPositionTracking[] $driverPositionTrackings
 * @property Driver[] $drivers
 * @property int $id_vehicle
 * @property int $id_vehicle_type
 * @property string $license_plate
 * @property string $no_stnk
 * @property string $no_bpkb
 * @property string $created_at
 * @property string $updated_at
 */
class Vehicle extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_vehicle';

    /**
     * @var array
     */
    protected $fillable = ['id_vehicle_type', 'license_plate', 'no_stnk', 'no_bpkb', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicleType()
    {
        return $this->belongsTo('App\Http\Models\VehicleType', 'id_vehicle_type', 'id_vehicle_type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function driverPositionTrackings()
    {
        return $this->hasMany('App\Http\Models\DriverPositionTracking', 'id_vehicle', 'id_vehicle');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function drivers()
    {
        return $this->hasMany('App\Http\Models\Driver', 'id_vehicle', 'id_vehicle');
    }
}
