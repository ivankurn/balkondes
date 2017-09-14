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
    protected $fillable = ['id_transaction', 'name', 'email', 'mobilephone', 'created_at', 'updated_at'];
}
