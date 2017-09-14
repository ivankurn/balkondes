<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property Vehicle $vehicle
 * @property DriverEnquiry[] $driverEnquiries
 * @property DriverSchedule[] $driverSchedules
 * @property int $id_driver
 * @property int $id_vehicle
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $address
 * @property string $birthday
 * @property string $KTP
 * @property string $SIM
 * @property string $created_at
 * @property string $updated_at
 */
class Driver extends Model
{
    protected $connection = 'mysql'; 
    
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'drivers';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_driver';

    /**
     * @var array
     */
    protected $fillable = ['id_vehicle', 'name', 'phone', 'email', 'password', 'address', 'birthday', 'KTP', 'SIM', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Http\Models\Vehicle', 'id_vehicle', 'id_vehicle');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function driverEnquiries()
    {
        return $this->hasMany('App\Http\Models\DriverEnquiry', 'id_driver', 'id_driver');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function driverSchedules()
    {
        return $this->hasMany('App\Http\Models\DriverSchedule', 'id_driver', 'id_driver');
    }
}
