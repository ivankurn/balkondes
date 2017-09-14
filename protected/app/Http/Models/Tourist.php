<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property TouristJourney[] $touristJourneys
 * @property TouristPackage[] $touristPackages
 * @property int $id_tourist
 * @property string $name
 * @property string $email
 * @property string $mobilephone
 * @property string $created_at
 * @property string $updated_at
 */
class Tourist extends Model
{
    protected $connection = 'mysql'; 
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tourists';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_tourist';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'mobilephone', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function touristJourneys()
    {
        return $this->hasMany('App\Http\Models\TouristJourney', 'id_tourist', 'id_tourist');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function touristPackages()
    {
        return $this->hasMany('App\Http\Models\TouristPackage', 'id_tourist', 'id_tourist');
    }
}
