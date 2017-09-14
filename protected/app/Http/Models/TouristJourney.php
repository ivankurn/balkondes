<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DriverSchedule $driverSchedule
 * @property Tourist $tourist
 * @property int $id_tourist_journey
 * @property int $id_driver_schedule
 * @property int $id_tourist
 * @property string $created_at
 * @property string $updated_at
 */
class TouristJourney extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'TouristJourneys';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_tourist_journey';

    /**
     * @var array
     */
    protected $fillable = ['id_driver_schedule', 'id_tourist', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driverSchedule()
    {
        return $this->belongsTo('App\Http\Models\DriverSchedule', 'id_driver_schedule', 'id_driver_schedule');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourist()
    {
        return $this->belongsTo('App\Http\Models\Tourist', 'id_tourist', 'id_tourist');
    }
}
