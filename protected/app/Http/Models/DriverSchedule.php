<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Driver $driver
 * @property Balkonde $balkonde
 * @property TouristJourney[] $touristJourneys
 * @property int $id_driver_schedule
 * @property int $id_driver
 * @property int $id_balkondes
 * @property int $id_balkondes_end
 * @property string $pickup_time
 * @property string $departure_time
 * @property string $arrived_time
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class DriverSchedule extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'driverschedules';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_driver_schedule';

    /**
     * @var array
     */
    protected $fillable = ['id_driver', 'id_balkondes_distance', 'pickup_time', 'departure_time', 'arrived_time', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo('App\Http\Models\Driver', 'id_driver', 'id_driver');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balkonde()
    {
        return $this->belongsTo('App\Http\Models\Balkonde', 'id_balkondes', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function touristJourneys()
    {
        return $this->hasMany('App\Http\Models\TouristJourney', 'id_driver_schedule', 'id_driver_schedule');
    }
}
