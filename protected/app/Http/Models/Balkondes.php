<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Village $village
 * @property Attraction[] $attractions
 * @property BalkondesDistance[] $balkondesDistances
 * @property BalkondesDistance[] $balkondesDistances
 * @property DriverSchedule[] $driverSchedules
 * @property EstimationTime[] $estimationTimes
 * @property EstimationTime[] $estimationTimes
 * @property PackageBalkonde[] $packageBalkondes
 * @property User[] $users
 * @property int $id_balkondes
 * @property string $id_village
 * @property string $name
 * @property string $description
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 */
class Balkondes extends Model
{
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Balkondes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_balkondes';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'phone', 'latitude', 'longitude', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function village()
    {
        return $this->belongsTo('App\Http\Models\Village', 'id_village', 'id_village');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attractions()
    {
        return $this->hasMany('App\Http\Models\Attraction', 'id_tourist_village', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function balkondesDistances()
    {
        return $this->hasMany('App\Http\Models\BalkondesDistance', 'id_balkondes_from', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function balkondesDistances2()
    {
        return $this->hasMany('App\Http\Models\BalkondesDistance', 'id_balkondes_to', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function driverSchedules()
    {
        return $this->hasMany('App\Http\Models\DriverSchedule', 'id_balkondes', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estimationTimes()
    {
        return $this->hasMany('App\Http\Models\EstimationTime', 'id_balkondes_start', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estimationTimes2()
    {
        return $this->hasMany('App\Http\Models\EstimationTime', 'id_balkondes_end', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packageBalkondes()
    {
        return $this->hasMany('App\Http\Models\PackageBalkonde', 'id_balkondes', 'id_balkondes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Http\Models\User', 'UserBalkondes', 'id_balkondes', 'id_user');
    }
}
