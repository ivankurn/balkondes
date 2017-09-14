<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EstimationTime[] $estimationTimes
 * @property PackageBalkonde[] $packageBalkondes
 * @property Vehicle[] $vehicles
 * @property int $id_vehicle_type
 * @property string $vehicle_type
 * @property int $price_km
 * @property string $created_at
 * @property string $updated_at
 */
class VehicleType extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'vehicletypes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_vehicle_type';

    /**
     * @var array
     */
    protected $fillable = ['vehicle_type', 'price_km', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estimationTimes()
    {
        return $this->hasMany('App\Http\Models\EstimationTime', 'id_vehicle_type', 'id_vehicle_type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packageBalkondes()
    {
        return $this->hasMany('App\Http\Models\PackageBalkonde', 'id_vehicle_type', 'id_vehicle_type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles()
    {
        return $this->hasMany('App\Http\Models\Vehicle', 'id_vehicle_type', 'id_vehicle_type');
    }
}
